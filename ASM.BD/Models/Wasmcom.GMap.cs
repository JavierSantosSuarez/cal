using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace ASM.BD.Models
{
	public partial class GMap
	{
        public class GeoPoint
        {
            public double lat { get; set; }
            public double lng { get; set; }
        }

        public class HojaRepartidor
        {
            public Int16 CodPlaza { get; set; }
            public Int32 CodRepartidor { get; set; }
            public Int32 Hoja { get; set; }
            public DateTime Fecha { get; set; }
            public String Estado { get; set; }
            public List<tReparto> Expediciones { get; set; }

            public Int16 ExpsEntregadas { get; set; }
            public Int16 ExpsIncidencia { get; set; }
            public Int16 ExpsPendientes { get { return Convert.ToInt16(Expediciones.Count - ExpsEntregadas - ExpsIncidencia); } }

            public float PorcentajeExpsEntregadas { get { return (float)ExpsEntregadas / Expediciones.Count * 100; } }
            public float PorcentajeExpsIncidencia { get { return (float)ExpsIncidencia / Expediciones.Count * 100; } }
            public float PorcentajeExpsPendientes { get { return (float)ExpsPendientes / Expediciones.Count * 100; } }

            public static List<HojaRepartidor> BuscaPorFecha(Int16 codPlaza, Int32 codRepartidor, DateTime fecha)
            {
                List<HojaRepartidor> hojas = new List<HojaRepartidor>();

                using (WASMCOMEntities w = new WASMCOMEntities())
                {
                    var q = from h in w.tRepartoHojas
                            where h.codplaza_rep == codPlaza
                            && h.codrepartidor == codRepartidor
                            && h.fecha == fecha
                            select h;

                    foreach (tRepartoHojas h in q)
                    {
                        HojaRepartidor hoja = new HojaRepartidor()
                        {
                            CodPlaza = h.codplaza,
                            CodRepartidor = h.codrepartidor,
                            Hoja = h.hoja,
                            Fecha = h.fecha,
                            Estado = h.estado == null || h.estado == 0 ? "Abierta" : h.estado == 1 ? "Cerrada" :  "Liquidada"
                        };

                        var reps = from r in w.tReparto
                                   where r.codplaza == hoja.CodPlaza
                                   && r.hoja == hoja.Hoja
                                   select r;

                        hoja.ExpsEntregadas = 0;
                        hoja.ExpsIncidencia = 0;
                        hoja.Expediciones = new List<tReparto>();

                        foreach (tReparto r in reps)
                        {
                            switch (r.liquidacion)
                            {
                                case -1: 
                                    hoja.ExpsEntregadas++;
                                    break;
                                case 0: 
                                    break;
                                default:
                                    hoja.ExpsIncidencia++;
                                    break;
                            }
                            hoja.Expediciones.Add(r);
                        }

                        hojas.Add(hoja);
                    }
                }


                return hojas;
            }
        }
        public class DatosRepartidorFecha
        {
            public List<tPdaPosiciones> Posiciones { get; set; }
            public List<HojaRepartidor> MyProperty { get; set; }
        }

        public static List<tPdaPosiciones> GetRutaRepartidor(Int16 codplaza, Int32 codrepartidor, DateTime fecha)
        {
            using (WASMCOMEntities w = new WASMCOMEntities())
            {
                DateTime fechamax = fecha.AddDays(1);

                var q = from p in w.tPdaPosiciones
						
                        where p.codplaza_rep == codplaza
                        && p.codrepartidor == codrepartidor
                        && p.fpda > fecha
                        && p.fpda < fechamax
						orderby	p.fpda
                        select p;

                return q.ToList();
            }
        }

        
        public static List<geoPlazas> GetCodPlazaLatLon(Int16 codplaza)
        {
            using (WASMCOMEntities w = new WASMCOMEntities())
            {
                //DateTime fechamax = fecha.AddDays(1);

                var q = from g in w.geoPlazas
                        where g.codplaza == codplaza
                        select g;
                
                return q.ToList();
            }
        }
        
        public static List<GeoPoint> DecodePolylinePoints(string encodedPoints)
        {
            if (encodedPoints == null || encodedPoints == "") return null;
            List<GeoPoint> poly = new List<GeoPoint>();
            char[] polylinechars = encodedPoints.ToCharArray();
            int index = 0;

            int currentLat = 0;
            int currentLng = 0;
            int next5bits;
            int sum;
            int shifter; 

            try
            {
                while (index < polylinechars.Length)
                {
                    // calculate next latitude
                    sum = 0;
                    shifter = 0;
                    do
                    {
                        next5bits = (int)polylinechars[index++] - 63;
                        sum |= (next5bits & 31) << shifter;
                        shifter += 5;
                    } while (next5bits >= 32 && index < polylinechars.Length);

                    if (index >= polylinechars.Length)
                        break;

                    currentLat += (sum & 1) == 1 ? ~(sum >> 1) : (sum >> 1);

                    //calculate next longitude
                    sum = 0;
                    shifter = 0;
                    do
                    {
                        next5bits = (int)polylinechars[index++] - 63;
                        sum |= (next5bits & 31) << shifter;
                        shifter += 5;
                    } while (next5bits >= 32 && index < polylinechars.Length);

                    if (index >= polylinechars.Length && next5bits >= 32)
                        break;

                    currentLng += (sum & 1) == 1 ? ~(sum >> 1) : (sum >> 1);
                    GeoPoint p = new GeoPoint();
                    p.lat = Convert.ToDouble(currentLat) / 100000.0;
                    p.lng = Convert.ToDouble(currentLng) / 100000.0;
                    poly.Add(p);
                }
            }
            catch (Exception)
            {
                // logo it
            }
            return poly;
        }
	}
}