using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using ASM.BD.Models;

namespace ASM.Calidad.Controllers
{
    public class ExpedicionesController : Controller
    {
        //
        // GET: /Expediciones/

        public ActionResult Index(Int32 codexp )
        {
            expediciones e = Wasmcom.GetExpedicion(codexp.ToString());

            return View(e);
        }

    }
}
