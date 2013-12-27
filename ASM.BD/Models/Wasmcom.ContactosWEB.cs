using ASM.BD.Helpers;
using MvcJqGrid;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Web;

namespace ASM.BD.Models
{
    public partial class webContactosTracking
    {

        public string NombreTipo
        {
            get
            {
                return tipo == 0 ? "Apertura" : tipo == 1 ? "Seguimiento" : "Cierre";
            }
        }

        public webContactosTracking(Int64 idcnt)
        {
            this.idContacto = idcnt;
        }

        public webContactosTracking()
        {
        }


        public bool GrabaBD()
        {
            if (!HttpContext.Current.User.Identity.IsAuthenticated) return false;
                  
            WASMCOMEntities w = new WASMCOMEntities();
            try
            {
                if (this.fecha == null) this.fecha = DateTime.Now;
                if (this.fecha == DateTime.MinValue) this.fecha = DateTime.Now;
                this.usuario = HttpContext.Current.User.Identity.Name;
                w.webContactosTracking.Add(this);

                if (this.tipo == 2)
                {
                    webContactos contacto = 
                        (from c in w.webContactos
                        where c.id == this.idContacto
                        select c).FirstOrDefault();

                    contacto.estado = 1;
                }
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


    [MetadataType(typeof(webContactosMetaData))]
    public partial class webContactos
    {
        private string plaza;

        public string Plaza
        {
            get
            {
                if (string.IsNullOrEmpty(plaza) && codplaza != null)
                {
                    tplazas p = Wasmcom.GetPlaza(codplaza.ToString());
                    if (p != null) plaza = p.plaza;
                }
                return plaza;
            }
            set
            {
                if (plaza != value)
                {
                    plaza = value;
                }
            }
        }

        public string NombreEstado
        {
            get
            {
                return estado == 0 ? "Abierto" : "Cerrado";
            }
        }

    }
    public class webContactosMetaData
    {
    }

    public partial class ContactosWEB
    {

        public List<webContactos> GetContactos(GridSettings grid, string abiertas, string cerradas, string fechadesde, ref int pageIndex, ref int pageSize, ref int totalRecords, ref int totalPages)
        {
            WASMCOMEntities w = new WASMCOMEntities();
            List<Int16> misPlazas = (new Seguridad()).GetMisPlazasConsulta();


            var q = 
                from wc in w.webContactos
                from p in w.tplazas.Where(p => p.codplaza == wc.codplaza).DefaultIfEmpty()
                where (misPlazas.Contains(wc.codplaza.Value))
                select new 
                {
                    wc.id,
                    wc.codplaza,
                    wc.contacto,
                    wc.cp,
                    wc.direccion,
                    wc.email,
                    wc.empresa,
                    wc.estado,
                    wc.fecha,
                    wc.peticion,
                    wc.poblacion,
                    wc.telefono,
                    wc.texto,
                    p.plaza
                };




            bool bAbiertas = true;
            bool bCerradas = true;
            DateTime dFechaDesde;

            bool.TryParse(abiertas, out bAbiertas);
            bool.TryParse(cerradas, out bCerradas);




            if (!(bAbiertas && bCerradas) && (bAbiertas || bCerradas))
            {
                if (bAbiertas) q = q.Where(wc => wc.estado == 0);
                if (bCerradas) q = q.Where(wc => wc.estado == 1);
            }

            if (DateTime.TryParse(fechadesde, out dFechaDesde))
            {
                q = q.Where(r => r.fecha >= dFechaDesde);
            }

            

            if (grid.IsSearch)
            {
                foreach (var rule in grid.Where.rules)
                {
                    //q = q.Where(rule.field, rule.data, WhereOperation.Equal);
                    switch (rule.field)
                    {
                        default:
                            q = q.Where(rule.field, rule.data, WhereOperation.Equal);
                            break;
                    }
                }
            }

            if (grid.SortColumn == "") grid.SortColumn = "fecha";
            q = q.OrderBy(grid.SortColumn, grid.SortOrder);

            pageIndex = grid.PageIndex;
            pageSize = grid.PageSize;
            totalRecords = q.Count();
            totalPages = (int)Math.Ceiling((float)totalRecords / (float)pageSize);

            int startRow = (pageIndex - 1) * pageSize;
            int endRow = startRow + pageSize;

            q = q.Skip((pageIndex - 1) * pageSize).Take(pageSize);

            List<webContactos> contactos = new List<webContactos>(pageSize);

            foreach (var con in q)
            {
                webContactos c = new webContactos();
                    c.id = con.id;
                    c.codplaza = con.codplaza;
                    c.contacto = con.contacto;
                    c.cp = con.cp;
                    c.direccion = con.direccion;
                    c.email = con.email;
                    c.empresa = con.empresa;
                    c.estado = con.estado;
                    c.fecha = con.fecha;
                    c.peticion = con.peticion;
                    c.poblacion = con.poblacion;
                    c.telefono = con.telefono;
                    c.texto = con.texto;
                    //c.plaza = con.plaza;

                contactos.Add(c);
            }

            w.Dispose();
            return contactos;

        }
        public List<webContactosTracking> GetTrackingContacto(GridSettings grid, Int64 id, ref int pageIndex, ref int pageSize, ref int totalRecords, ref int totalPages)
        {
            WASMCOMEntities w = new WASMCOMEntities();

            var q =
                from t in w.webContactosTracking
                where (t.idContacto == id)
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

            List<webContactosTracking> trk = q.ToList();

            w.Dispose();
            return trk;

        }

    }
}