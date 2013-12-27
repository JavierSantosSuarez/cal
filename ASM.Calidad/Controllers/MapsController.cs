using ASM.BD.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;


namespace ASM.Calidad.Controllers
{
    public class MapsController : Controller
    {
        //
        // GET: /Maps/

        string GOOGLE_API_KEY = "AIzaSyCQEpHQRd8FtlvDJUDtSXBRWhlNWaZxz6w";

        private class TPosiciones
        {
            public string Longitud { get; set; }
            public string Latitud { get; set; }
            public string Fecha { get; set; }
            public string Expedicion { get; set; }
            public string Tipo { get; set; }
            public string Icono { get; set; }
            public int Count { get; set; }
            public List<GMap.GeoPoint> Ruta { get; set; }

        }

        public ActionResult Index()
        {
            //List<tPdaPosiciones> posiciones = GMap.GetRutaRepartidor(80, 259, DateTime.Now.Date);
            //return View(posiciones);

            return View();
        }
        public ActionResult ActualizaDatosMapa(Int16 codplaza, Int32 codrepartidor, string fecha)
        {
            DateTime f = DateTime.Parse(fecha);


            List<GMap.HojaRepartidor> hojas = GMap.HojaRepartidor.BuscaPorFecha(codplaza, codrepartidor, f);
            List<tPdaPosiciones> posiciones = GMap.GetRutaRepartidor(codplaza, codrepartidor, f);

            //List<geoPlazas> infoPlazas = GMap.GetCodPlazaLatLon(codplaza);

            string cpLat = "";
            string cpLon = "";
            /*
            foreach (geoPlazas infoPlaza in infoPlazas)
            {
                cpLat = Convert.ToString(infoPlaza.lat).Replace(",", ".");
                cpLon = Convert.ToString(infoPlaza.lon).Replace(",", ".");
            }
            */
            string oldlt = "";
            string oldln = "";
            string oldtp = "";
            DateTime minHora = DateTime.MaxValue;
            DateTime maxHora = DateTime.MinValue;

            List<TPosiciones> ps = new List<TPosiciones>();
            TPosiciones p = new TPosiciones();
            foreach (tPdaPosiciones posicion in posiciones)
            {
                if (posicion.fpda > maxHora) maxHora = Convert.ToDateTime(posicion.fpda);
                if (posicion.fpda < minHora) minHora = Convert.ToDateTime(posicion.fpda);

                string lt = posicion.latitud.Replace(",", ".");
                string ln = posicion.longitud.Replace(",", ".");
                string fc = Convert.ToDateTime(posicion.fpda).ToString("dd/MM/yyyy HH:mm");
                string ex = posicion.codexp.ToString();
                string tp = posicion.tipo.ToString();

                if (tp != oldtp || lt != oldlt || ln != oldln )
                {
                    if (!string.IsNullOrEmpty(p.Tipo))
                    {
                        switch (p.Tipo)
                        {
                            case "1": 
                                p.Icono = "/Images/truck.png";
                                break;
                            case "2":
                                p.Icono = string.Format("/Images/entregas/number_{0}.png", p.Count);
                                break;
                            case "3":
                                p.Icono = string.Format("/Images/incidencias/number_{0}.png", p.Count);
                                break;
                            default:
                                break;
                        }

                        ps.Add(p);
                    }

                    oldtp = tp;
                    oldlt = lt;
                    oldln = ln;

                    p = new TPosiciones();
                    p.Longitud = ln;
                    p.Latitud = lt;
                    p.Fecha = fc;
                    p.Tipo = tp;
                    p.Expedicion = "";
                    p.Count = 0;
                    if (tp == "1" && !string.IsNullOrEmpty(posicion.polyLine)) p.Ruta = GMap.DecodePolylinePoints(posicion.polyLine);
                }
                p.Expedicion += ex + " ";
                p.Count++;
            }



            var result = new
            {
                resultado = posiciones.Count,
                posiciones = ps,
                maxHora = maxHora.Hour * 60 + maxHora.Minute,
                minHora = minHora.Hour * 60 + minHora.Minute,
                hojas = hojas,
                codPlazaLat = cpLat,
                codPlazaLon = cpLon
            };

            return Json(result, JsonRequestBehavior.AllowGet);
            
        }

    }
}
