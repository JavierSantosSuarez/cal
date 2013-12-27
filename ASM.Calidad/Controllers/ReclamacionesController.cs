using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using ASM.BD.Models;
using MvcJqGrid;
using ASM.BD.Helpers;
using ASM.Library.Models;


namespace ASM.Calidad.Controllers
{
    [Authorize]
    public class ReclamacionesController : Controller
    {
        #region Gets
        

        public ActionResult Index()
        {
            return View();
        }
        public ActionResult NuevaReclamacion()
        {
            return View(new clReclamaciones());
        }
        public ActionResult NuevoTracking(Int64 id, byte tipoTracking )
        {
            return View(new clTrackingReclamacion(id) { tipoTracking = tipoTracking  });
        }
        public ActionResult Valida(Int64 id)
        {
            return View("NuevoTracking", new clTrackingReclamacion(id) { tipoTracking = 3 });
        }
        public ActionResult Invalida(Int64 id)
        {
            return View("NuevoTracking", new clTrackingReclamacion(id) { tipoTracking = 4 });
        }

        #endregion

        #region Posts
        

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult NuevaReclamacion(clReclamaciones reclamacion)
        {
            if (ModelState.IsValid)
            {
                if (reclamacion.GrabaBD())
                {
                    return RedirectToAction("Index");
                }
            }
            return View(reclamacion);
        }
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult NuevoTracking(clTrackingReclamacion tracking)
        {
            if (ModelState.IsValid)
            {
                if (tracking.GrabaBD())
                {
                    return RedirectToAction("Index");
                }
            }
            return View(tracking);
        }


        [HttpPost]
        public ActionResult CheckCodexp(object codexp)
        {
            //ASM.BD.Models.Wasmcom w = new Wasmcom();


            expediciones e = Wasmcom.GetExpedicion(codexp.ToString());
            if (e == null)
            {
                return Json(new { resultado = -1 });
            }
            else
            {
                return Json(new { resultado = 0, codplaza = e.codplaza_dst });
            }

        }
        [HttpPost]
        public ActionResult GetPlaza(object codplaza)
        {
            tplazas p = Wasmcom.GetPlaza(codplaza.ToString());
            if (p == null)
            {
                return Json(new { resultado = -1 });
            }
            else
            {
                return Json(new { resultado = 0, plaza = p });
            }
        }

        #endregion

        public ActionResult ReclamacionesPendientes(GridSettings grid, string abiertas, string cerradas, string fechadesde)
        {
            ASM.BD.Models.Calidad c = new ASM.BD.Models.Calidad();
            int pageIndex=0, pageSize=0, totalRecords=0, totalPages=0;
            var data = c.GetReclamaciones(grid, abiertas, cerradas, fechadesde, ref pageIndex, ref pageSize, ref totalRecords, ref totalPages);

            var result = new
            {
                total = totalPages,
                page = pageIndex,
                records = totalRecords,
                rows = (from reclamacion in data
                        select new
                        {
                            Id = reclamacion.id,
                            CodPlazaReclama  = reclamacion.codplazaReclama,
                            CodPlazaReclamada = reclamacion.codplazaReclamada,
                            CodPlazaPenalizada = reclamacion.codplazaPenalizada,
                            CodPlazaIndemnizada = reclamacion.codplazaIndemnizada,
                            CodExp = reclamacion.codexp,
                            CodRecogida = reclamacion.codrecogida,
                            FechaInicio = reclamacion.fechaInicio,
                            PlazaReclama = reclamacion.PlazaReclama,
                            PlazaReclamada = reclamacion.PlazaReclamada,
                            ImportePenalizacion = reclamacion.importePenalizacion,
                            ImporteIndemnizacion = reclamacion.importeIndemnizacion,
                            Estado = reclamacion.Estado,
                
                        }).ToArray()
            };

            return Json(result, JsonRequestBehavior.AllowGet);
        }
        public ActionResult TrackingReclamacion(GridSettings grid, Int64 id)
        {
            ASM.BD.Models.Calidad c = new ASM.BD.Models.Calidad();
            int pageIndex = 0, pageSize = 0, totalRecords = 0, totalPages = 0;
            

            var data = c.GetTrackingReclamacion(grid, id,  ref pageIndex, ref pageSize, ref totalRecords, ref totalPages);

            var result = new
            {
                total = totalPages,
                page = pageIndex,
                records = totalRecords,
                rows = (from tracking in data
                        select tracking
                        ).ToArray()
            };

            return Json(result, JsonRequestBehavior.AllowGet);
        }

        public ActionResult GetPlazas(string term)
        {
            ASM.BD.Models.Wasmcom w = new Wasmcom();

            List<tplazas> plazas = w.GetPlazasConsulta(term);
            List<string> nombres = new List<string>();

            foreach (tplazas plaza in plazas)
            {
                nombres.Add(string.Format("{0} - {1}",plaza.codplaza ,plaza.plaza));
            }

            return Json(nombres, JsonRequestBehavior.AllowGet);
        }
        public ActionResult GetServicios(string term)
        {
            ASM.BD.Models.Wasmcom w = new Wasmcom();
            List<Servicio> servicios = w.GetServicios(term,5);
            List<AutoCompleteReturn> ret = new List<AutoCompleteReturn>();
 

            foreach (Servicio servicio in servicios)
            {
                AutoCompleteReturn r = new AutoCompleteReturn();
                r.label = servicio.Referencia;
                r.value = servicio.Codigo;
                r.descripcion = string.Format("{0} {1}", servicio.TipoServicio.ToString(), servicio.Codigo);
                r.tipo = servicio.TipoServicio.ToString();
                r.adicional01 = servicio.CodPlazaDst.ToString();

                r.help = servicio.HtmlHelp;

                ret.Add(r);

                
            }
            return Json(ret, JsonRequestBehavior.AllowGet);
        }



    }
}
