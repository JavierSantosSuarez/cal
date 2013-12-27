using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using MvcJqGrid;
using ASM.BD.Helpers;
using System.Web.Mvc;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel;
using ASM.Library;

namespace ASM.BD.Models
{
    public partial class clTrackingReclamacion
    {
        [DisplayName("Penalización")]
        public decimal ImportePenalizacion { get; set; }
        [DisplayName("Indemnización")]
        public decimal ImporteIndemnizacion { get; set; }
        [DisplayName("Invertir cargos")]
        public bool InvertirCargos { get; set; }

        public string NombreTipo 
        { 
            get
            {
                string nombre = "";
                using (WASMCOMEntities w = new WASMCOMEntities())
                {
                    nombre = (from t in w.clTiposTrackingReclamacion
                               where t.tipoTracking == this.tipoTracking
                               select t.nombre).FirstOrDefault();
                }
                return nombre;
            }
        }

        public clTrackingReclamacion(Int64 idrec)
        {
            this.idReclamacion = idrec;
        }

        public clTrackingReclamacion()
        {
        }


        public bool GrabaBD()
        {
//#if DEBUG

//            WASMCOMEntities ww = new WASMCOMEntities();

//            clReclamaciones rr =
//                        (from r in ww.clReclamaciones
//                         where r.id == this.idReclamacion
//                         select r).FirstOrDefault();

//            rr.cerrada = true;
//            rr.codplazaPenalizada = rr.codplazaReclamada;
//            rr.importeIndemnizacion = ImporteIndemnizacion;
//            rr.importePenalizacion = ImportePenalizacion;
//            rr.invertirCargos = InvertirCargos;

//            rr.OnCierre();


            
//            return true;
//#endif


            if (!HttpContext.Current.User.Identity.IsAuthenticated) return false;

            WASMCOMEntities w = new WASMCOMEntities();
            try
            {
                if (this.fecha == DateTime.MinValue) this.fecha = DateTime.Now;
                this.usuario = HttpContext.Current.User.Identity.Name;
                w.clTrackingReclamacion.Add(this);
                w.SaveChanges();

                if (this.tipoTracking == 3 || this.tipoTracking ==4) // Aceptada/rechazada
                {
                    if (this.tipoTracking == 4)
                    {
                        ImporteIndemnizacion = 0;
                        ImportePenalizacion = 0;
                    }

                    clTrackingReclamacion cerrada = new clTrackingReclamacion();
                    cerrada.tipoTracking = 5;
                    cerrada.fecha = DateTime.Now;
                    cerrada.idReclamacion = this.idReclamacion;
                    cerrada.observaciones = "Cerrada automaticamente";
                    cerrada.usuario = HttpContext.Current.User.Identity.Name;
                    w.clTrackingReclamacion.Add(cerrada);

                    clReclamaciones reclamacion =
                        (from r in w.clReclamaciones
                        where r.id == this.idReclamacion
                        select r).FirstOrDefault();

                    reclamacion.cerrada = true;
                    reclamacion.importeIndemnizacion = ImporteIndemnizacion;
                    reclamacion.importePenalizacion = ImportePenalizacion;
                    reclamacion.invertirCargos = InvertirCargos;

                    if (reclamacion.codplazaPenalizada == null && reclamacion.importePenalizacion > 0)
                    {
                        reclamacion.codplazaPenalizada = reclamacion.codplazaReclamada;
                    }

                    if (reclamacion.codplazaIndemnizada == null && reclamacion.importeIndemnizacion > 0)
                    {
                        reclamacion.codplazaIndemnizada = reclamacion.codplazaReclama;
                    }
                    w.SaveChanges();

                    reclamacion.OnCierre();

                }


                w.Dispose();
            }
            catch
            {
                w.Dispose();
                return false;
            }

            return true;
        }

        private IEnumerable<clTiposTrackingReclamacion> GetTiposTrackingReclamacion()
        {
            WASMCOMEntities w = new WASMCOMEntities();
            var q = from t in w.clTiposTrackingReclamacion
                    select t;

            return q.ToList();
        }
        public IEnumerable<SelectListItem> TiposTrackingReclamacionItems
        {
            get { return new SelectList(GetTiposTrackingReclamacion(), "tipoTracking", "nombre"); }
        }

    }

    [MetadataType(typeof(clReclamacionesMetaData))]
    public partial class clReclamaciones
    {
        private string plazaReclama;
        private string plazaReclamada;
        private string plazaIndemnizada;
        private string plazaPenalizada;

        public string PlazaReclama
        {
            get
            {
                if (string.IsNullOrEmpty(plazaReclama) && codplazaReclama != null)
                {
                    tplazas p = Wasmcom.GetPlaza(codplazaReclama.ToString());
                    if (p != null) plazaReclama = p.plaza;
                }
                return plazaReclama;
            }
            set
            {
                if (plazaReclama != value)
                {
                    plazaReclama = value;
                }
            }
        }
        public string PlazaReclamada
        {
            get
            {
                if (string.IsNullOrEmpty(plazaReclamada) && codplazaReclamada != null)
                {
                    tplazas p = Wasmcom.GetPlaza(codplazaReclamada.ToString());
                    if (p != null) plazaReclamada = p.plaza;
                }
                return plazaReclamada;
            }
            set
            {
                if (plazaReclamada != value)
                {
                    plazaReclamada = value;
                }
            }
        }
        public string PlazaIndemnizada
        {
            get
            {
                if (string.IsNullOrEmpty(plazaIndemnizada) && codplazaIndemnizada != null)
                {
                    tplazas p = Wasmcom.GetPlaza(codplazaIndemnizada.ToString());
                    if (p != null) plazaIndemnizada = p.plaza;
                }
                return plazaIndemnizada;
            }
            set
            {
                if (plazaIndemnizada != value)
                {
                    plazaIndemnizada = value;
                }
            }
        }
        public string PlazaPenalizada
        {
            get
            {
                if (string.IsNullOrEmpty(plazaPenalizada) && codplazaPenalizada != null)
                {
                    tplazas p = Wasmcom.GetPlaza(codplazaPenalizada.ToString());
                    if (p != null) plazaPenalizada = p.plaza;
                }
                return plazaPenalizada;
            }
            set
            {
                if (plazaPenalizada != value)
                {
                    plazaPenalizada = value;
                }
            }
        }
        public string Estado { get; set; }
        public string ObservacionesAlta { get; set; }

        public string NombreTipoReclamacion
        {
            get
            {
                return (TiposReclamacion.Where(t => t.tipoReclamacion == tipoReclamacion).FirstOrDefault()).nombre;
            }
            
        }

        public IEnumerable<clTiposReclamacion> TiposReclamacion { get { return GetTiposReclamacion(); } }
        public IEnumerable<clTrackingReclamacion> Tracking { get { return GetTracking(); } }
        

        public clReclamaciones()
        {
            this.codplazaReclama = new Seguridad().GetMiCodPlaza();
            this.cerrada = false;
        }

        public void AplicaImportes()
        {
            if (importePenalizacion != 0)
            {
            }
            if (importeIndemnizacion != 0)
            {
            }
            if (invertirCargos == true)
            {
            }
        }

        public bool GrabaBD()
        {
            if (!HttpContext.Current.User.Identity.IsAuthenticated) return false;

            WASMCOMEntities w = new WASMCOMEntities();
            try
            {
                //es obligatorio codexp o codrecogida
                if (this.codexp == null && this.codrecogida == null) return false;
                if (this.fechaInicio == null) this.fechaInicio = DateTime.Now;
                if (this.codplazaReclama == null) this.codplazaReclama = new Seguridad().GetMiCodPlaza();
                w.clReclamaciones.Add(this);
                w.SaveChanges();

                clTrackingReclamacion tr = new clTrackingReclamacion();
                tr.tipoTracking = 1;
                tr.fecha = DateTime.Now;
                tr.idReclamacion = this.id;
                tr.observaciones = string.IsNullOrEmpty(ObservacionesAlta) ? "Por grabación" : ObservacionesAlta;
                tr.usuario = HttpContext.Current.User.Identity.Name;

                w.clTrackingReclamacion.Add(tr);
                w.SaveChanges();

                w.Dispose();
            }
            catch
            {
                w.Dispose();
                return false;
            }

            return true;
        }

        private IEnumerable<clTrackingReclamacion> GetTracking()
        {
            WASMCOMEntities w = new WASMCOMEntities();
            var q = from t in w.clTrackingReclamacion
                    where t.idReclamacion == this.id
                    select t;

            return q.ToList();
        }
        private IEnumerable<clTiposReclamacion> GetTiposReclamacion()
        {
            WASMCOMEntities w = new WASMCOMEntities();
            var q = from t in w.clTiposReclamacion 
                    select t;

            return q.ToList();
        }
        public IEnumerable<SelectListItem> TiposReclamacionItems
        {
            get { return new SelectList(GetTiposReclamacion(), "tipoReclamacion", "nombre"); }
        }

        public void OnCierre()
        {
            if (importePenalizacion > 0) // Aceptada, aplico importes y mando mail
            {
                if (codexp != null) Wasmcom.PenalizaExpedicion((short)codplazaPenalizada, (Int32)codexp, (decimal)importePenalizacion, null, null, null, "Penalización por reclamación");
                if (codrecogida != null) Wasmcom.PenalizaSlRecogida((short)codplazaPenalizada, (Int64)codrecogida, (decimal)importePenalizacion, null, null, null, "Penalización por reclamación");

                string cuerpoMail = string.Format(
@"<br>Centro: <b>{0}</b>
<br>{1}: <b>{2}</b>
<br>Importe: <b>{3:C}</b>
<br><br>Estimada Agencia,
<br><br>Tras recibir reclamación del cliente remitente de la {1} arriba indicada y hacer las correspondientes comprobaciones al respecto, le informamos del importe de la penalización impuesta por FRAUDE EN LA EJECUCION DEL SERVICIO  (<b>{4}</b>) cuyo importe servirá para resarcir las demandas de dicho cliente.
<br><br>Puede consultar el expediente completo de dicha reclamación en la página web “Aquí ponemos la dirección de mail para acceder o el link” y si lo desea, alegar dicha resolución a través de esta misma aplicación.
<br><br>Un saludo
<br><br><i>CALIDAD DE RED</i>", PlazaPenalizada, codexp == null? "Recogida" : "Expedición", codexp == null? codrecogida : codexp, importePenalizacion ,NombreTipoReclamacion);

                //Mail.EnviaCorreoNoReply(Wasmcom.GetMailPlaza((short)codplazaPenalizada), "Penalización por reclamación", cuerpoMail);
                Mail.EnviaCorreoNoReply("jss.inf@asmred.es", "Penalización por reclamación", cuerpoMail);
                
                


            }
        }


    }
    public class clReclamacionesMetaData
    {
        

        [DisplayName("Plaza reclamante")]
        public Int16 codplazaReclama {get; set;}

        [DisplayName("Plaza reclamada")]
        public Int16 codplazaReclamada { get; set; }

        [DisplayName("Tipo de reclamación")]
        public byte? tipoReclamacion { get; set; }

    }

    public partial class Calidad
    {
        public List<clReclamaciones> GetReclamaciones(GridSettings grid, string abiertas, string cerradas, string fechadesde, ref int pageIndex, ref int pageSize, ref int totalRecords, ref int totalPages)
        {
            WASMCOMEntities w = new WASMCOMEntities();
            List<Int16> misPlazas = (new Seguridad()).GetMisPlazasConsulta();

            var q =
                from r in w.clReclamaciones
                from p1 in w.tplazas.Where(p1 => p1.codplaza == r.codplazaReclama).DefaultIfEmpty()
                from p2 in w.tplazas.Where(p2 => p2.codplaza == r.codplazaReclamada).DefaultIfEmpty()
                from p3 in w.tplazas.Where(p3 => p3.codplaza == r.codplazaPenalizada).DefaultIfEmpty()
                from p4 in w.tplazas.Where(p4 => p4.codplaza == r.codplazaIndemnizada).DefaultIfEmpty()
                where ( misPlazas.Contains(r.codplazaReclama.Value) 
                || misPlazas.Contains(r.codplazaReclamada.Value))

                select new
                {
                    id = r.id,
                    tipoReclamacion = r.tipoReclamacion,
                    codplazaReclama = r.codplazaReclama,
                    codplazaReclamada = r.codplazaReclamada,
                    fechaInicio = r.fechaInicio,
                    fechaFin = r.fechaFin,
                    codexp = r.codexp,
                    codrecogida = r.codrecogida,
                    importePenalizacion = r.importePenalizacion,
                    importeIndemnizacion = r.importeIndemnizacion,
                    codplazaPenalizada = r.codplazaPenalizada,
                    codplazaIndemnizada = r.codplazaIndemnizada,
                    PlazaReclama = p1.plaza,
                    PlazaReclamada = p2.plaza,
                    PlazaPenalizada = p3.plaza,
                    PlazaIndemnizada = p4.plaza,
                    Cerrada = r.cerrada
                };

            
            
            
            bool bAbiertas = true;
            bool bCerradas = true;
            DateTime dFechaDesde;

            bool.TryParse(abiertas, out bAbiertas);
            bool.TryParse(cerradas, out bCerradas);




            if (!(bAbiertas && bCerradas) && (bAbiertas || bCerradas))
            {
                if (bAbiertas) q = q.Where(r => r.Cerrada == false);
                if (bCerradas) q = q.Where(r => r.Cerrada == true);
            }

            if (DateTime.TryParse(fechadesde, out dFechaDesde))
            {
                q = q.Where(r => r.fechaInicio >= dFechaDesde);
            }



            if (grid.IsSearch)
            {
                foreach (var rule in grid.Where.rules)
                {
                    //q = q.Where(rule.field, rule.data, WhereOperation.Equal);
                    switch (rule.field)
                    {
                        case "CodPlazaReclama":
                            short codplazaReclama = Convert.ToInt16(rule.data);
                            q = q.Where(r => r.codplazaReclama == codplazaReclama);
                            break;

                        case "CodPlazaReclamada":
                            short codplazaReclamada = Convert.ToInt16(rule.data);
                            q = q.Where(r => r.codplazaReclamada == codplazaReclamada);
                            break;
                        case "CodPlazaPenalizada":
                            short codplazaPenalizada = Convert.ToInt16(rule.data);
                            q = q.Where(r => r.codplazaPenalizada == codplazaPenalizada);
                            break;

                        case "CodPlazaIndemnizada":
                            short codplazaIndemnizada = Convert.ToInt16(rule.data);
                            q = q.Where(r => r.codplazaIndemnizada == codplazaIndemnizada);
                            break;

                        case "ImportePenalizacion":
                            decimal importePenalizacion = Convert.ToDecimal(rule.data);
                            q = q.Where(r => r.importePenalizacion >= importePenalizacion);
                            break;
                        case "ImporteIndemnizacion":
                            decimal importeIndemnizacion = Convert.ToDecimal(rule.data);
                            q = q.Where(r => r.importeIndemnizacion >= importeIndemnizacion);
                            break;

                        case "CodExp":
                            int codexp = Convert.ToInt32(rule.data);
                            q = q.Where(r => r.codexp >= codexp);
                            break;
                        case "CodRecogida":
                            Int64 codrecogida = Convert.ToInt64(rule.data);
                            q = q.Where(r => r.codrecogida >= codrecogida);
                            break;
                        default:
                            q = q.Where(rule.field, rule.data, WhereOperation.Equal);
                            break;
                    }
                }
            }

            if (grid.SortColumn == "") grid.SortColumn = "FechaInicio";
            q = q.OrderBy(grid.SortColumn, grid.SortOrder);

            //q = q.OrderBy<clReclamaciones>(grid.SortColumn, grid.SortOrder);

            pageIndex = grid.PageIndex;
            pageSize = grid.PageSize;
            totalRecords = q.Count();
            totalPages = (int)Math.Ceiling((float)totalRecords / (float)pageSize);

            int startRow = (pageIndex - 1) * pageSize;
            int endRow = startRow + pageSize;

            //return q.Skip((pageIndex - 1) * pageSize).Take(pageSize).ToArray();

            q = q.Skip((pageIndex - 1) * pageSize).Take(pageSize);

            List<clReclamaciones> recs = new List<clReclamaciones>(pageSize);

            foreach (var rec in q)
            {
                clReclamaciones r = new clReclamaciones();
                r.id = rec.id;
                r.tipoReclamacion = rec.tipoReclamacion;
                r.codplazaReclama = rec.codplazaReclama;
                r.codplazaReclamada = rec.codplazaReclamada;
                r.fechaInicio = rec.fechaInicio;
                r.fechaFin = rec.fechaFin;
                r.codexp = rec.codexp;

                r.codrecogida = rec.codrecogida;
                r.importePenalizacion = rec.importePenalizacion;
                r.importeIndemnizacion = rec.importeIndemnizacion;
                r.codplazaPenalizada = rec.codplazaPenalizada;
                r.codplazaIndemnizada = rec.codplazaIndemnizada;
                r.PlazaReclama = rec.PlazaReclama;
                r.PlazaReclamada = rec.PlazaReclamada;
                r.PlazaPenalizada = rec.PlazaPenalizada;
                r.PlazaIndemnizada = rec.PlazaIndemnizada;
                r.Estado = rec.Cerrada ? "Cerrada" : "Abierta";

                recs.Add(r);
            }

            w.Dispose();
            return recs;

        }
        public List<clTrackingReclamacion> GetTrackingReclamacion(GridSettings grid, Int64 id, ref int pageIndex, ref int pageSize, ref int totalRecords, ref int totalPages)
        {
            WASMCOMEntities w = new WASMCOMEntities();

            var q =
                from t in w.clTrackingReclamacion
                where (t.idReclamacion == id)
                select t;


            if (grid.SortColumn == "") grid.SortColumn = "Fecha";
            q = q.OrderBy(grid.SortColumn, grid.SortOrder);

            pageIndex = grid.PageIndex;
            pageSize = grid.PageSize;
            totalRecords = q.Count();
            totalPages = (int)Math.Ceiling((float)totalRecords / (float)pageSize);

            int startRow = (pageIndex - 1) * pageSize;
            int endRow = startRow + pageSize;

            q = q.Skip((pageIndex - 1) * pageSize).Take(pageSize);

            List<clTrackingReclamacion> trk = q.ToList();


            w.Dispose();
            return trk;

        }
    }
}