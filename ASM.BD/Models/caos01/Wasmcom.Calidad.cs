using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace ASM.BD.Models
{
	public partial class Wasmcom
	{
        public IQueryable<clReclamaciones> GetReclamaciones()
        {
            WasmcomEntities w = new WasmcomEntities();

            var q =
                from r in w.clReclamaciones
                join p1 in w.tplazas on r.codplazaReclama equals p1.codplaza
                join p2 in w.tplazas on r.codplazaReclamada equals p2.codplaza
                select new clReclamaciones
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

         //           PlazaReclama = p1.plaza,
         //           PlazaReclamada = p2.plaza
                };

            return q;

        }
	}

    public partial class clReclamaciones
    {
       // public string PlazaReclama { get; set; }
       // public string PlazaReclamada { get; set; }

        public bool GrabaBD()
        {
            WasmcomEntities w = new WasmcomEntities();
            try
            {
                if (this.fechaInicio == null) this.fechaInicio = DateTime.Now;
                w.clReclamaciones.Add(this);
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
    }


    
}