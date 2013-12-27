using System;
using System.Collections.Generic;
using System.Data.Objects.SqlClient;
using System.Linq;
using System.Web;

namespace ASM.BD.Models
{
	public enum TiposServicio
	{
		EXPEDICION,SLRECOGIDA
	}

	public class Direccion
	{
		public Int16 CodPlaza { get; set; }
		public string Nombre { get; set; }
		public string Calle { get; set; }
		public string Localidad { get; set; }
		public string CodigoPostal { get; set; }
		public string Departamento { get; set; }
		public string Telefono { get; set; }
	}
	public class Cliente
	{
		string nombre;

		public Int16? CodPlaza { get; set; }
		public Int32? Codigo { get; set; }
		public string Nombre { get 
		{
			if (string.IsNullOrWhiteSpace(nombre))
			{
				using (WASMCOMEntities w = new WASMCOMEntities())
				{
					string nombreCliente =

						(from cli in w.tclientes
						where cli.codcli == this.Codigo
						where cli.codplaza == this.CodPlaza
						select cli.nombre).FirstOrDefault();
					nombre = nombreCliente;
				}

			}
			return nombre; 
		} set { if (nombre != value) nombre = value; } }
	}

	public class Servicio
	{
		public string Codigo { get { if (CodExp > 0) return CodExp.ToString(); else return CodRecogida.ToString(); } }

		public Int32 CodExp { get; set; }
		public Int64 CodRecogida { get; set; }

		public string Referencia { get; set; }
		public TiposServicio TipoServicio { get; set; }
		public DateTime? Fecha { get; set; }

		public Int16 CodPlazaOrg { get; set; }
		public Int16 CodPlazaDst { get; set; }
		public Int16 CodPlazaPaga { get; set; }

		public Direccion Origen { get; set; }
		public Direccion Destino { get; set; }

		public Cliente Cliente { get; set; }

		public Servicio()
		{
			Origen = new Direccion();
			Destino = new Direccion();
			Cliente = new Cliente();
			
		}

		public string HtmlHelp
		{
			get
			{
				string help = "";
				switch (TipoServicio)
				{
					case TiposServicio.EXPEDICION:
						help += string.Format("<h1>{0} {1}</h1>", "Expedición" , Codigo);
						help += string.Format("<h3>Origen {0} - Destino {1} - Paga {2}</h3>", CodPlazaOrg, CodPlazaDst, CodPlazaPaga);
						break;
					case TiposServicio.SLRECOGIDA:
						help += string.Format("<h1>{0} {1}</h1>", "Sol/Recogida" , Codigo);
						help += string.Format("<h3>Recoger en {0} - Paga {2}</h3>", CodPlazaOrg, CodPlazaDst, CodPlazaPaga);
						break;
					default:
						break;
				}
				help += string.Format("<h3>{0}</h3>", Cliente.Nombre);
				help += string.Format("<h3>{0}</h3>", Convert.ToDateTime(Fecha).ToShortDateString());

				help += string.Format("<h2>Origen</h2>");
				help += string.Format("{0}", Origen.Nombre);
				help += string.Format("<br/ >{0}", Origen.Calle);
				help += string.Format("<br/ >{0} {1}", Origen.CodigoPostal, Origen.Localidad);
				help += string.Format("<br/ >{0}", Origen.Departamento);

				Direccion dummy = new Direccion();

				if (TipoServicio == TiposServicio.EXPEDICION)
				{
					help += string.Format("<h2>Destino</h2>");
					help += string.Format("{0}", Destino.Nombre);
					help += string.Format("<br/ >{0}", Destino.Calle);
					help += string.Format("<br/ >{0} {1}", Destino.CodigoPostal, Destino.Localidad);
					help += string.Format("<br/ >{0}", Destino.Departamento);
				}

				return help;
			}
		}
	}
	public partial class Wasmcom
	{
		public static expediciones GetExpedicion(string codigo)
		{
			expediciones expedicion=null;
			using (WASMCOMEntities w = new WASMCOMEntities())
			{
				Int32 exp;
				if (Int32.TryParse(codigo, out exp))
				{
					w.Database.ExecuteSqlCommand("exec config.dbo.secActivaCuenta 'ParaTareas'");
					expedicion = (from e in w.expediciones
								  where e.codexp == exp
								  select e).FirstOrDefault();
				}
			}

			return expedicion;

		}
		public static tplazas GetPlaza(string codigo)
		{
			tplazas plaza = null;
			using (WASMCOMEntities w = new WASMCOMEntities())
			{
				Int16 codplaza;
				if (Int16.TryParse(codigo, out codplaza))
				{
					plaza = (from p in w.tplazas
							 where p.codplaza == codplaza
							 select p).FirstOrDefault();
				}
			}
			return plaza;
		}

        public static string GetMailPlaza(Int16 codplaza)
        {
            string mail = null;
            using (WASMCOMEntities w = new WASMCOMEntities())
            {
                    mail = (from p in w.tplazas
                             where p.codplaza == codplaza
                             select p).FirstOrDefault().mail;
            }
            return mail;

        }

		public List<Servicio> GetServicios(string codigo, Int16 top = 0, DateTime? fechaDesde = null)
		{
			if (fechaDesde == null) fechaDesde = DateTime.Now.AddMonths(-1);

			List<Servicio> servicios = new List<Servicio>();
			//using (WASMCOMEntities w = new WASMCOMEntities())
			WASMCOMEntities w = new WASMCOMEntities();
			{
				//Int64 iCodigo = 0;
				// Si el codigo es numérico, busco por codexp y por codrecogida
				var expediciones =
					w.treferencias
					.Join(w.texpediciones, r => r.codexp, e => e.codexp, (refs, exps) => new { refs, exps })
					.Join(w.texpdetalle, r => r.exps.codexp, e => e.codexp, (rexps, det) => new { rexps, det })
					.Where(r => r.det.ultimo == "S")
					.Where(r => r.rexps.exps.fecha >= fechaDesde)
					.Where(r => r.rexps.refs.referencia.StartsWith(codigo))
					.Select(r => new Servicio()
					{
						CodExp = r.rexps.exps.codexp,
						CodRecogida = 0L,
						Referencia = r.rexps.refs.referencia,
						TipoServicio = TiposServicio.EXPEDICION,
						Fecha = r.rexps.exps.fecha,
						Origen = new Direccion()
						{
							CodPlaza = r.det.codplaza_org,
							Calle = r.rexps.exps.calle_org,
							Nombre = r.rexps.exps.nombre_org,
							CodigoPostal = r.rexps.exps.cp_org,
							Localidad = r.rexps.exps.localidad_org,
							Departamento = r.rexps.exps.departamento_org,
							Telefono = r.rexps.exps.tfno_org
						},
						Destino = new Direccion()
						{
							CodPlaza = r.det.codplaza_dst,
							Calle = r.rexps.exps.calle_dst,
							Nombre = r.rexps.exps.nombre_dst,
							CodigoPostal = r.rexps.exps.cp_dst,
							Localidad = r.rexps.exps.localidad_dst,
							Departamento = r.rexps.exps.departamento_dst,
							Telefono = r.rexps.exps.tfno_dst
						},
						Cliente = new Cliente()
						{
							CodPlaza = r.det.codplaza_cli,
							Codigo = r.det.codcli
						},
						CodPlazaOrg = r.det.codplaza_org,
						CodPlazaDst = r.det.codplaza_dst,
						CodPlazaPaga = r.det.codplaza_pag
					});

				var solicitudes  = 
					w.tslrReferencias
					.Join(w.tslrRecogidas, r => r.CodRecogida, s => s.CodRecogida, (r, sol) => new { r.referencia, r.CodRecogida, sol })
					.Where(r => r.referencia.StartsWith(codigo))
					.Where(r => r.sol.FRecogida >= fechaDesde)
				   .Select(r => new Servicio()
				   {
					   CodExp = 0,
					   CodRecogida = r.CodRecogida,
					   Referencia = r.referencia,
					   TipoServicio = TiposServicio.SLRECOGIDA,
					   Fecha = r.sol.FRecogida,
					   Origen = new Direccion()
					   {
						   CodPlaza = r.sol.CodPlaza_org,
						   Calle = r.sol.DirRec,
						   Nombre = r.sol.NombRec,
						   CodigoPostal = r.sol.cpRec,
						   Localidad = r.sol.PoblRec,
						   Departamento = r.sol.DptoRec,
						   Telefono = r.sol.TfnoRec
					   },
					   Cliente = new Cliente()
					   {
						   CodPlaza = r.sol.CodPlaza_sol,
						   Codigo = r.sol.Codcli
					   },
					   CodPlazaOrg = r.sol.CodPlaza_org,
					   CodPlazaDst = r.sol.CodPlaza_org,
					   CodPlazaPaga = r.sol.CodPlaza_sol
				   });

                /*
				if (Int64.TryParse(codigo, out iCodigo))
				{
					expediciones = expediciones.Union(
						w.texpdetalle
						.Join(w.texpediciones, d => d.codexp, e => e.codexp, (det, exp) => new { det, exp })

						.Where(e => e.det.ultimo == "S")
						.Where(e => e.det.codexp == iCodigo)

					.Select(r => new Servicio()
					{
						CodExp = r.exp.codexp,
						CodRecogida = 0L,
						Referencia = "" ,
						TipoServicio = TiposServicio.EXPEDICION,
						Fecha = r.exp.fecha,
						Origen = new Direccion()
						{
							CodPlaza = r.det.codplaza_dst,
							Calle = r.exp.calle_dst,
							Nombre = r.exp.nombre_dst,
							CodigoPostal = r.exp.cp_dst,
							Localidad = r.exp.localidad_dst,
							Departamento = r.exp.departamento_dst,
							Telefono = r.exp.tfno_dst
						},
						Destino = new Direccion()
						{
							CodPlaza = r.det.codplaza_dst,
							Calle = r.exp.calle_dst,
							Nombre = r.exp.nombre_dst,
							CodigoPostal = r.exp.cp_dst,
							Localidad = r.exp.localidad_dst,
							Departamento = r.exp.departamento_dst,
							Telefono = r.exp.tfno_dst
						},
						Cliente = new Cliente()
						{
							CodPlaza = r.det.codplaza_cli,
							Codigo = r.det.codcli
						},

						CodPlazaOrg = r.det.codplaza_org,
						CodPlazaDst = r.det.codplaza_dst,
						CodPlazaPaga = r.det.codplaza_pag
					})
						);
					solicitudes = solicitudes.Union(
						w.tslrRecogidas
						.Where(s => s.CodRecogida == iCodigo)
				   .Select(r => new Servicio()
				   {
					   CodExp = 0,
					   CodRecogida = r.CodRecogida,
					   Referencia = "",
					   TipoServicio = TiposServicio.SLRECOGIDA,
					   Fecha = r.FRecogida,
					   Origen = new Direccion()
					   {
						   CodPlaza = r.CodPlaza_org,
						   Calle = r.DirRec,
						   Nombre = r.NombRec,
						   CodigoPostal = r.cpRec,
						   Localidad = r.PoblRec,
						   Departamento = r.DptoRec,
						   Telefono = r.TfnoRec
					   },
					   Cliente = new Cliente()
					   {
						   CodPlaza = r.CodPlaza_sol,
						   Codigo = r.Codcli
					   },
					   CodPlazaOrg = r.CodPlaza_org,
					   CodPlazaDst = r.CodPlaza_org,
					   CodPlazaPaga = r.CodPlaza_sol
				   })
						);
				}*/
				servicios = solicitudes.Distinct().ToList();
				servicios = servicios.Concat(
					expediciones.Distinct()
					).ToList();
			}

			return servicios;
		}


		//public List<Servicio> GetServiciosV01(string codigo, Int16 top = 0, DateTime? fechaDesde = null)
		//{
		//    if (fechaDesde == null) fechaDesde = DateTime.Now.AddMonths(-1);

		//    List<Servicio> servicios = new List<Servicio>();
		//    using (WASMCOMEntities w = new WASMCOMEntities())
		//    {
		//        Int64 iCodigo = 0;
		//        // Si el codigo es numérico, busco por codexp y por codrecogida
		//        var q =
		//            w.treferencias
		//            .Join(w.texpediciones, r => r.codexp, e => e.codexp, (refs, exps) => new { refs, exps })
		//            .Join(w.texpdetalle, r => r.exps.codexp, e => e.codexp, (rexps, det) => new { rexps, det })
		//            .Where(r => r.det.ultimo == "S")
		//            .Where(r => r.rexps.exps.fecha >= fechaDesde)
		//            .Where(r => r.rexps.refs.referencia.StartsWith(codigo))
		//            .Select(r => new Servicio()
		//            {
		//                CodExp = r.rexps.exps.codexp,
		//                CodRecogida = 0L,
		//                Referencia = r.rexps.refs.referencia,
		//                TipoServicio = TiposServicio.EXPEDICION,
		//                Fecha = r.rexps.exps.fecha,
		//                Origen = new Direccion()
		//                {
		//                    CodPlaza = r.det.codplaza_dst,
		//                    Calle = r.rexps.exps.calle_dst,
		//                    Nombre = r.rexps.exps.nombre_dst,
		//                    CodigoPostal = r.rexps.exps.cp_dst,
		//                    //Telefono = "12332111",
		//                    //Localidad = "localidad",
		//                    //Departamento = "dpto"
		//                    Localidad = r.rexps.exps.localidad_dst,
		//                    Departamento = r.rexps.exps.departamento_dst,
		//                    Telefono = r.rexps.exps.tfno_dst
		//                },
		//                CodPlazaOrg = r.det.codplaza_dst,
		//                CodPlazaDst = r.det.codplaza_dst,
		//                CodPlazaPaga = r.det.codplaza_pag
		//            });

		//        q = q.Union(
		//            w.tslrReferencias
		//            .Join(w.tslrRecogidas, r => r.CodRecogida, s => s.CodRecogida, (r, sol) => new { r.referencia, r.CodRecogida, sol })
		//            .Where(r => r.referencia.StartsWith(codigo))
		//            .Where(r => r.sol.FRecogida >= fechaDesde)
		//           .Select(r => new Servicio()
		//           {
		//               CodExp = 0,
		//               CodRecogida = r.CodRecogida,
		//               Referencia = r.referencia,
		//               TipoServicio = TiposServicio.SLRECOGIDA,
		//               Fecha = r.sol.FRecogida,
		//               Origen = new Direccion()
		//               {
		//                   CodPlaza = r.sol.CodPlaza_dst,
		//                   Calle = r.sol.DirRec,
		//                   Nombre = r.sol.NombRec,
		//                   CodigoPostal = r.sol.cpRec,
		//                   //Telefono = "12332111",
		//                   //Localidad = "localidad",
		//                   //Departamento = "dpto"

		//                   Localidad = r.sol.PoblRec,
		//                   Departamento = r.sol.DptoRec,
		//                   Telefono = r.sol.TfnoRec
		//               },
		//               CodPlazaOrg = r.sol.CodPlaza_org,
		//               CodPlazaDst = r.sol.CodPlaza_org,
		//               CodPlazaPaga = r.sol.CodPlaza_sol
		//           })
		//            //{ Codigo = r.CodRecogida, Referencia = r.referencia, TipoServicio = TiposServicio.SLRECOGIDA })
		//            );
				 


		//        if (Int64.TryParse(codigo, out iCodigo))
		//        {
		//            //q = q.Union(
		//            //    w.texpdetalle
		//            //    .Join(w.texpediciones, d => d.codexp, e => e.codexp, (det, exp) => new { det, exp })

		//            //    .Where(e => e.det.ultimo == "S")
		//            //    .Where(e => e.det.codexp == iCodigo)
						
		//            //.Select(r => new Servicio()
		//            //{
		//            //    CodExp = r.exp.codexp,
		//            //    CodRecogida = 0L,
		//            //    Referencia = "",
		//            //    TipoServicio = TiposServicio.EXPEDICION,
		//            //    Fecha = r.exp.fecha,
		//            //    Origen = new Direccion()
		//            //    {
		//            //        CodPlaza = r.det.codplaza_dst,
		//            //        Calle = r.exp.calle_dst,
		//            //        Nombre = r.exp.nombre_dst,
		//            //        CodigoPostal = r.exp.cp_dst,
		//            //        Localidad = "localidad",
		//            //        Departamento = "dpto",
		//            //        Telefono = "12332111"

		//            //        //Localidad = r.exp.localidad_dst,
		//            //        //Departamento = r.exp.departamento_dst,
		//            //        //Telefono = r.exp.tfno_dst
		//            //    },
		//            //    CodPlazadst = r.det.codplaza_dst,
		//            //    CodPlazaDst = r.det.codplaza_dst,
		//            //    CodPlazaPaga = r.det.codplaza_pag
		//            //})
		//            //    );
		//            q = q.Union(
		//                w.tslrRecogidas
		//                .Where(s => s.CodRecogida == iCodigo)
		//           .Select(r => new Servicio()
		//           {
		//               CodExp = 0,
		//               CodRecogida = r.CodRecogida,
		//               Referencia = "",
		//               TipoServicio = TiposServicio.SLRECOGIDA,
		//               Fecha = r.FRecogida,
		//               Origen = new Direccion()
		//               {
		//                   CodPlaza = r.CodPlaza_dst,
		//                   Calle = r.DirRec,
		//                   Nombre = r.NombRec,
		//                   CodigoPostal = r.cpRec,
		//                   Localidad = r.PoblRec,
		//                   Departamento = r.DptoRec,
		//                   Telefono = r.TfnoRec
		//               },
		//               CodPlazadst = r.CodPlaza_dst,
		//               CodPlazaDst = r.CodPlaza_dst,
		//               CodPlazaPaga = r.CodPlaza_sol
		//           })
		//                );
		//        }
		//        servicios = q.Distinct().ToList();
		//        //servicios = q.ToList();
		//    }
		//    return servicios;
		//}

		public List<tplazas> GetPlazasConsulta(string parcial)
		{
			List<tplazas> plazas = null;

			int iparcial, codplaza01=999, codplaza02=0;
			

			if (int.TryParse(parcial, out iparcial))
			{
				if (iparcial < 10)
				{
					codplaza01 = iparcial * 100;
					codplaza02 = int.Parse(iparcial.ToString("0") + "99");
				}
				else if (iparcial < 100)
				{
					codplaza01 = iparcial * 10;
					codplaza02 = int.Parse(iparcial.ToString("00") + "9");
				}
				else 
				{
					codplaza01 = iparcial;
					codplaza02 = iparcial;
				} 

			}
			
			using (WASMCOMEntities w = new WASMCOMEntities())
			{

				var q = (from p in w.tplazas
						 where p.operativa == "S"
						 select p);

				if (!string.IsNullOrEmpty(parcial))
				{
					q = q.Where(p => p.plaza.Contains(parcial) || (p.codplaza >= codplaza01 && p.codplaza<= codplaza02));
				}
				plazas = q.ToList<tplazas>();
			}

			return plazas;
		}

		public static int SetEstadoExp(Int32 codexp, Int16 codestado, string informacion, DateTime? fecha,Int16? codplaza_org )
		{
			int ret=0;
			if (fecha == DateTime.MinValue) fecha = null;
			using (WASMCOMEntities w = new WASMCOMEntities())
			{
				if (codplaza_org == null)
				{
					codplaza_org = (from e in w.texpediciones
									where e.codexp == codexp
									select e.codplaza_org).FirstOrDefault();
				}


				string sql = "declare @ret int;";
				sql += " exec @ret=wasmcom.dbo.stpExpInsertaEstado";
				sql += " @codplaza_org={0}";
				sql += " ,@codexp={1}";
				sql += " ,@codestado={2}";
				sql += " ,@informacion={3}";
				sql += " ,@fecha={4};";
				sql += " select @ret;";

				var q = w.Database.SqlQuery<int>(sql, codplaza_org, codexp, codestado, informacion, fecha);
				ret = q.FirstOrDefault();

				//w.Database.ExecuteSqlCommand(sql, codplaza_org, codexp,codestado,informacion,fecha);
				//ret = w.stpExpInsertaEstado(codplaza_org, codexp, codestado, informacion, fecha, null, null, null, null, null, null, null, null, true, false);
			}

			return ret;
		}

	}
}