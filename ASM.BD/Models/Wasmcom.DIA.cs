using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Web;
using System.Xml.Linq;

namespace ASM.BD.Models
{
    public partial class DIA
    {
        public enum TipoTransaccion
        {
            PET,
            ANU,
            Desconocido
        }
        public enum TipoPeticion
        {
            LLEGADA,
            RECOGIDA,
            DEVOLUCION,
            CADUCADO,
            Desconocido
        }

        public class Transaccion
        {
            private string error = "";

            public Int64 Id { get; set; }
            public TipoTransaccion Tipo { get; set; }
            public TipoPeticion Peticion { get; set; }
            public string TPVId { get; set; }
            public string LocalRef { get; set; }
            public string Producto { get; set; }
            public DateTime Fecha { get; set; }
            public Int32 CodigoTienda { get; set; }
            
            public string EAN13 { get; set; }
            public string CodBarras { get; set; }
            public string CodBarrasExpedicion 
            { 
                get
                {
                    if (string.IsNullOrEmpty(CodBarras)) return null;
                    if (CodBarras.Length != 14 && CodBarras.Length != 17 && CodBarras.Length != 18) return null;

                    return CodBarras.Substring(0, 14);
                }
            }

            public string Resultado { get; set; }
            public string Error
            {
                get
                {
                    string val = error;
                    if (Tipo == TipoTransaccion.Desconocido) error += "\nTipo de Transaccion desconocido";
                    if (Peticion == TipoPeticion.Desconocido) error += "\nTipo de Peticion desconocido";

                    return val;
                }

                set
                {
                    error = value;
                }
            }
            public bool TieneError
            {
                get
                {
                    return (!(string.IsNullOrEmpty(Error)) || Peticion == TipoPeticion.Desconocido || Tipo == TipoTransaccion.Desconocido);
                }
            }

            public Transaccion()
            {
            }
            public Transaccion(XDocument mensaje)
            {
                try
                {
                    XElement transac = mensaje.Element("Transac");
                    XElement comando = transac.Element("Comando");
                    XElement datosEntrada = comando.Element("DatosEntrada");

                    Id = Convert.ToInt64(transac.Attribute("ID").Value);
                    SetTipo(comando.Attribute("Tipo").Value);

                    TPVId = comando.Element("TPVID").Value;
                    LocalRef = comando.Element("LocalRef").Value;
                    Producto = comando.Element("Producto").Value;
                    Fecha = DateTime.ParseExact(comando.Element("Fecha").Value + comando.Element("Hora").Value, "yyyyMMddHHmmss", CultureInfo.InvariantCulture);

                    if (datosEntrada != null)
                    {
                        foreach (XElement dato in datosEntrada.Descendants())
                        {
                            if (Tipo == TipoTransaccion.PET && dato.Name == "Dato1")
                            {
                                EAN13 = dato.Value;
                            }
                            if (Tipo == TipoTransaccion.PET && dato.Name == "Dato2")
                            {
                                CodBarras = dato.Value;
                            }
                        }
                    }
                    SetPeticion();
                    CodigoTienda = Convert.ToInt32(LocalRef.Substring(4, 6));
                }
                catch (Exception)
                {
                    Error = "Mensaje XML mal formado";
                    Resultado = "-199";
                }
            }

            public XDocument GeneraMensaje()
            {
                XDocument mensaje = new XDocument();
                XElement transac = new XElement("Transac");
                try
                {
                    transac.SetAttributeValue("ID", Id);
                    XElement respuesta = new XElement("Respuesta");
                    respuesta.SetAttributeValue("Tipo", Tipo.ToString());

                    respuesta.SetElementValue("LocalRef", LocalRef);
                    respuesta.SetElementValue("Resultado", Resultado);
                    respuesta.SetElementValue("DescripcionError", Error);

                    XElement datosRespuesta = new XElement("DatosRespuesta");
                    if (!string.IsNullOrEmpty(EAN13)) datosRespuesta.SetElementValue("Dato1", EAN13);
                    if (!string.IsNullOrEmpty(CodBarras)) datosRespuesta.SetElementValue("Dato2", CodBarras);

                    respuesta.Add(datosRespuesta);
                    transac.Add(respuesta);
                }
                catch (Exception e)
                {
                    mensaje.Add(new XElement("ERROR", e.Message));
                }

                mensaje.Add(transac);

                return mensaje;

            }

            public void Procesa()
            {
                if (TieneError) return;
                if (CodBarrasExpedicion == null)
                {
                    Error = string.Format("{0} No es un codigo de barras válido",CodBarras);
                    Resultado = "-3";
                    return;
                }

                using (WASMCOMEntities w = new WASMCOMEntities())
                {

                    var expedicion = (from cc in w.texp_codbar_cli
                                      //join det2 in w.TExpDetalle2 on new { cc.codexp, cc.codplaza_org } equals new { det2.codexp, det2.Codplaza_org }
                                from det2 in w.TExpDetalle2 
                                where 
                                cc.codbar == CodBarrasExpedicion
                                && det2.Codplaza_org == cc.codplaza_org
                                && det2.codexp == cc.codexp
                                && det2.ultimo == "S"

                                select new { cc.codexp, cc.codplaza_org, det2.dninom, det2.CodDestinatario }).FirstOrDefault();

                    
                    //var expedicion = (from cc in w.texp_codbar_cli
                    //                  //join det2 in w.TExpDetalle2 on new { cc.codexp, cc.codplaza_org } equals new { det2.codexp, det2.Codplaza_org }
                    //                  join det2 in w.TExpDetalle2 on cc.codexp equals det2.codexp
                    //                  where cc.codbar == CodBarrasExpedicion
                    //                  && det2.ultimo == "S"
                    //                  select new { cc.codexp, cc.codplaza_org, det2.dninom, det2.CodDestinatario }).FirstOrDefault();

                    if (expedicion == null)
                    {
                        Error = string.Format("No existe la expedición", CodBarras);
                        Resultado = "-4";
                        return;
                    }

                    if (expedicion.dninom != 7)
                    {
                        Error = "No está solicitada la entrega en DIA";
                        Resultado = "-5";
                        return;
                    }

                    //Esto habrá que ver si es un warning y como lo hacemos llegar
                    if (expedicion.CodDestinatario != CodigoTienda)
                    {
                        Error = "No está solicitada para esta tienda DIA";
                        Resultado = "-6";
                        return;
                    }

                    //Comprobar que está en el estado apropiado -- esto lo meto en el stored --
                    //// para todas no final
                    //// para llegada no puede estar entregada en punto dia
                    //// para recogida debe estar entregada en punto dia 
                    //// para devolucion
                    //// para caducado

                    //Llegada
                    int ret = -99;
                    switch (Peticion)
                    {
                        case TipoPeticion.LLEGADA:
                            ret = Wasmcom.SetEstadoExp(expedicion.codexp, 22, "Por comm DIA", DateTime.Now, expedicion.codplaza_org);
                            switch (ret)
                            {
                                case 0:
                                    Resultado = "OK";
                                    break;
                                case -1:
                                    Resultado = "KO";
                                    Error = "ERROR, NO EXISTE EXPEDICION";
                                    break;
                                case -2:
                                    Resultado = "KO";
                                    Error = "ERROR, ESTA EN ESTADO FINAL";
                                    break;
                                default:
                                    Resultado = "KO";
                                    Error = "Error desconocido";
                                    break;
                            }
                            break;
                        case TipoPeticion.RECOGIDA:
                            ret = Wasmcom.SetEstadoExp(expedicion.codexp, 7, "Por comm DIA", DateTime.Now, expedicion.codplaza_org);
                            switch (ret)
                            {
                                case 0:
                                    Resultado = "OK";
                                    break;
                                case -1:
                                    Resultado = "KO";
                                    Error = "ERROR, NO EXISTE EXPEDICION";
                                    break;
                                case -2:
                                    Resultado = "KO";
                                    Error = "ERROR, ESTA EN ESTADO FINAL";
                                    break;
                                default:
                                    Resultado = "KO";
                                    Error = "Error desconocido";
                                    break;
                            }
                            break;
                        case TipoPeticion.DEVOLUCION:
                            break;
                        case TipoPeticion.CADUCADO:
                            break;
                        case TipoPeticion.Desconocido:
                            break;
                        default:
                            break;
                    }
                }
            }

            private void SetPeticion()
            {
                switch (EAN13)
                {
                    case "220000100001D":
                        Peticion = TipoPeticion.LLEGADA;
                        break;
                    case "220000100002D":
                        Peticion = TipoPeticion.RECOGIDA;
                        break;
                    case "220000100003D":
                        Peticion = TipoPeticion.DEVOLUCION;
                        break;
                    case "220000100004D":
                        Peticion = TipoPeticion.CADUCADO;
                        break;
                    default:
                        Peticion = TipoPeticion.Desconocido;
                        Resultado = "-199";
                        break;
                }
            }
            private void SetTipo(string tipo)
            {
                switch (tipo)
                {
                    case "PET":
                        Tipo = TipoTransaccion.PET;
                        break;
                    case "ANU":
                        Tipo = TipoTransaccion.ANU;
                        break;
                    default:
                        Tipo = TipoTransaccion.Desconocido;
                        Resultado = "-199";
                        break;
                }
            }
        }


        public static XDocument ProcesaMensajeXML(string mensaje)
        {
            try
            {
                XDocument messIn = XDocument.Parse(mensaje);
                return ProcesaMensajeXML(messIn);
            }
            catch (Exception)
            {
                return GeneraMensaje(0, "PET", "", "ERROR_XML", "No es un mensaje XML", null);
            }
        }
        public static XDocument ProcesaMensajeXML(XDocument mensaje)
        {
            try
            {
                Transaccion transaccion = new Transaccion(mensaje);
                if (!transaccion.TieneError)
                {
                    transaccion.Procesa();
                    //transaccion.Resultado = 
                }
                return transaccion.GeneraMensaje();
            }
            catch (Exception)
            {
                return GeneraMensaje(0, "PET", "", "ERROR_XML", "Mensaje XML mal formado", null);
            }
        }

        private static XDocument GeneraMensaje(Int64 id, string tipo, string localRef, string resultado, string error, string[] datos)
        {
            XDocument mensaje = new XDocument();
            XElement transac = new XElement("Transac");
            try
            {
                transac.SetAttributeValue("ID", id);
                XElement respuesta = new XElement("Respuesta");
                respuesta.SetAttributeValue("Tipo", tipo);

                respuesta.SetElementValue("LocalRef", localRef);
                respuesta.SetElementValue("Resultado", resultado);
                respuesta.SetElementValue("DescripcionError", error);

                XElement datosRespuesta = new XElement("DatosRespuesta");
                if (datos != null)
                {
                    int i = 0;
                    foreach (string dato in datos)
                    {
                        datosRespuesta.SetElementValue("Dato" + ++i, dato);
                    }
                }
                respuesta.Add(datosRespuesta);
                transac.Add(respuesta);
            }
            catch (Exception e)
            {
                mensaje.Add(new XElement("ERROR", e.Message));
            }

            mensaje.Add(transac);

            return mensaje;

        }

        public static void LeeConfiguracion(out string direccionIP, out string puerto, out bool autoarranque)
        {
            string aa;
            autoarranque = true;

            direccionIP = Config.GetConfiguracion("DIACommServer", "DireccionIP");
            puerto = Config.GetConfiguracion("DIACommServer", "Puerto");
            aa = Config.GetConfiguracion("DIACommServer", "AutoArranque");

            if (string.IsNullOrEmpty(direccionIP)) direccionIP = "127.0.0.1";
            if (string.IsNullOrEmpty(puerto)) puerto = "23";
            if (!string.IsNullOrEmpty(aa)) bool.TryParse(aa, out autoarranque);

            return;

        }

    }

}