using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace ASM.BD.Models
{
    public partial class Config
    {
        public static string GetConfiguracion(string seccion, string unidad)
        {
            string v=null;

            using (ConfigEntities cnf = new ConfigEntities())
            {
                v = (from c in cnf.cnfConfiguracion
                     where c.seccion == seccion
                     && c.unidad == unidad
                     && c.codCuenta == null
                     && c.codplaza == null
                     select c.valor).FirstOrDefault();
            }

            return v;
        }

    }
}