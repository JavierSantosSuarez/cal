//------------------------------------------------------------------------------
// <auto-generated>
//    This code was generated from a template.
//
//    Manual changes to this file may cause unexpected behavior in your application.
//    Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace ASM.BD.Models
{
    using System;
    using System.Collections.Generic;
    
    public partial class ExpedicionesResumen
    {
        public short codplaza_org { get; set; }
        public int codexp { get; set; }
        public string Expedicion { get; set; }
        public System.DateTime fecha { get; set; }
        public short codservicio { get; set; }
        public string nombre_org { get; set; }
        public string departamento_org { get; set; }
        public string nombre_dst { get; set; }
        public string departamento_dst { get; set; }
        public string calle_dst { get; set; }
        public Nullable<int> codlocalidad_dst { get; set; }
        public string localidad_dst { get; set; }
        public string cp_dst { get; set; }
        public string tfno_dst { get; set; }
        public string tipo_portes { get; set; }
        public string sabado { get; set; }
        public Nullable<decimal> valorDecl { get; set; }
        public Nullable<short> codhorario { get; set; }
        public string borrado { get; set; }
        public Nullable<short> codpais_org { get; set; }
        public Nullable<short> codprovincia_org { get; set; }
        public Nullable<short> codpais_dst { get; set; }
        public Nullable<short> codprovincia_dst { get; set; }
        public short codplaza_dst { get; set; }
        public short codplaza_pag { get; set; }
        public Nullable<short> codplaza_cli { get; set; }
        public Nullable<int> codcli { get; set; }
        public short nexp { get; set; }
        public decimal vol { get; set; }
        public Nullable<decimal> kgs { get; set; }
        public short bultos { get; set; }
        public Nullable<bool> AlbaranCliente { get; set; }
        public string retorno { get; set; }
        public string tfno_cnt { get; set; }
        public string pers_cnt { get; set; }
        public Nullable<System.DateTime> FPEntrega { get; set; }
        public string att_dst { get; set; }
        public string movil_dst { get; set; }
        public string dmail_dst { get; set; }
        public Nullable<short> est_mail { get; set; }
        public Nullable<System.DateTime> fecha_mail { get; set; }
        public string email_remite { get; set; }
        public Nullable<short> est_movil { get; set; }
        public Nullable<byte> dninom { get; set; }
        public short codestado { get; set; }
        public string informacion { get; set; }
        public string Albaran { get; set; }
        public string Refcli { get; set; }
        public string codbar { get; set; }
        public Nullable<double> Unidades { get; set; }
        public Nullable<long> codCalidad { get; set; }
        public string estado { get; set; }
        public string EstadoFinal { get; set; }
        public string Horario { get; set; }
        public string servicio { get; set; }
        public string Incidencia { get; set; }
        public Nullable<double> Debidos { get; set; }
        public string PathPod { get; set; }
    }
}
