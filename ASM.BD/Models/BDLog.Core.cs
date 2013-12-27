using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace ASM.BD.Models
{
	public partial class BDLog
	{
        public static void AddLogDia(string texto)
        {
            //return;
            using (BDLogEntities l = new BDLogEntities())
            {
                DiaLog log = new DiaLog();

                log.observaciones = texto;
                log.proceso = "LogDia";
                log.ftick = DateTime.Now;


                l.DiaLog.Add(log);
                l.SaveChanges();
            }
        }
    
        public static void AddLogDia(string texto, string xmlin, string xmlout)
        {
            //return;
            using (BDLogEntities l = new BDLogEntities())
            {
                DiaLog log = new DiaLog();

                log.observaciones = texto;
                log.proceso = "LogDia";
                log.xmlIn = xmlin;
                log.xmlOut = xmlout;
                log.ftick = DateTime.Now;


                l.DiaLog.Add(log);
                l.SaveChanges();
            }
        }
    }
}