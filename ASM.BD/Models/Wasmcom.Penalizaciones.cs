using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace ASM.BD.Models
{
	public partial class Wasmcom
	{
        public static bool PenalizaExpedicion(Int16 codplaza, Int32 codexp, decimal importe, byte? codtipo, Int16? codconcepto, DateTime? fechaPenaliza, string observaciones )
        {

            using (WASMCOMEntities w = new WASMCOMEntities())
            {
                TExpDetalle2 det2 = (from d in w.TExpDetalle2
                                     where d.codexp == codexp
                                     && d.ultimo == "S"
                                     select d).FirstOrDefault();
                if (det2 == null) return false;

                tplazas plz = (from p in w.tplazas
                               where p.codplaza == codplaza
                               select p).FirstOrDefault();
                if (plz == null) return false;

                if (fechaPenaliza == null) fechaPenaliza = DateTime.Now;
                if (codtipo == null) codtipo = 20;
                if (string.IsNullOrEmpty(observaciones)) observaciones = "Penalización Directa";

                pnlExpediciones penalizacion = new pnlExpediciones()
                {
                    codplaza_org = det2.Codplaza_org,
                    codexp = det2.codexp,
                    fechaPenaliza = (DateTime)fechaPenaliza,
                    FPEntrega = det2.FPEntrega,
                    codtipo = (byte)codtipo,
                    codconcepto = codconcepto,
                    importe = importe,
                    estado = 0,
                    tipoPenalizacion = 1,
                    observaciones = observaciones,
                    codplazaprov = plz.codplaza,
                    codprov = plz.codprov_red
                };

                w.SaveChanges();
            }
            return true;
        }
        public static bool PenalizaSlRecogida(Int16 codplaza, Int64 codRecogida, decimal importe, byte? codtipo, Int16? codconcepto, DateTime? fechaPenaliza, string observaciones)
        {

            using (WASMCOMEntities w = new WASMCOMEntities())
            {
                tslrRecogidas rec = (from r in w.tslrRecogidas
                                     where r.CodRecogida == codRecogida
                                     select r).FirstOrDefault();

                if (rec == null) return false;

                tplazas plz = (from p in w.tplazas
                               where p.codplaza == codplaza
                               select p).FirstOrDefault();
                if (plz == null) return false;

                if (fechaPenaliza == null) fechaPenaliza = DateTime.Now;
                if (codtipo == null) codtipo = 20;
                if (string.IsNullOrEmpty(observaciones)) observaciones = "Penalización Directa";

                pnlSlRecogidas penalizacion = new pnlSlRecogidas()
				{
					codRecogida = rec.CodRecogida,
                    fechaPenaliza = (DateTime)fechaPenaliza,
					FRecogida = rec.FRecogida,
                    codtipo = (byte)codtipo,
                    codconcepto = codconcepto,
                    importe = importe,
                    estado = 0,
                    tipoPenalizacion = 1,
                    observaciones = observaciones,
                    codplazaprov = plz.codplaza,
                    codprov = plz.codprov_red
                };

                w.SaveChanges();
            }
            return true;
        }

    }
}