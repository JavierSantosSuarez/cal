using ASM.BD.Models;
using MvcJqGrid;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace ASM.Calidad.Controllers
{
    public class ContactosWEBController : Controller
    {
        //
        // GET: /ContactosWEB/

        public ActionResult Index()
        {
            return View();
        }

        public ActionResult NuevoTracking(Int64 id, byte tipo)
        {
            return View(new webContactosTracking(id) { tipo = tipo });
        }


        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult NuevoTracking(webContactosTracking tracking)
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


        public ActionResult ContactosPendientes(GridSettings grid, string abiertas, string cerradas, string fechadesde)
        {
            ASM.BD.Models.ContactosWEB wc = new ASM.BD.Models.ContactosWEB();
            int pageIndex = 0, pageSize = 0, totalRecords = 0, totalPages = 0;
            var data = wc.GetContactos(grid, abiertas, cerradas, fechadesde, ref pageIndex, ref pageSize, ref totalRecords, ref totalPages);

            var result = new
            {
                total = totalPages,
                page = pageIndex,
                records = totalRecords,
                rows = (from contacto in data
                        select new
                        {
                            contacto.id,
                            contacto.codplaza,
                            contacto.contacto,
                            contacto.cp,
                            contacto.direccion,
                            contacto.email,
                            contacto.empresa,
                            contacto.estado,
                            contacto.fecha,
                            contacto.peticion,
                            contacto.poblacion,
                            contacto.telefono,
                            contacto.texto,
                            contacto.Plaza,
                            contacto.NombreEstado

                        }).ToArray()
            };

            return Json(result, JsonRequestBehavior.AllowGet);
        }
        public ActionResult TrackingContacto(GridSettings grid, Int64 id)
        {
            ASM.BD.Models.ContactosWEB wc = new ASM.BD.Models.ContactosWEB();
            int pageIndex = 0, pageSize = 0, totalRecords = 0, totalPages = 0;

            var data = wc.GetTrackingContacto(grid, id, ref pageIndex, ref pageSize, ref totalRecords, ref totalPages);

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


    }
}
