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
    
    public partial class expediciones
    {
        public short codplaza_org { get; set; }
        public int codexp { get; set; }
        public Nullable<System.DateTime> fecha { get; set; }
        public byte codtipo_envio { get; set; }
        public short codservicio { get; set; }
        public Nullable<short> codtipodst { get; set; }
        public string nombre_org { get; set; }
        public string departamento_org { get; set; }
        public string calle_org { get; set; }
        public Nullable<int> codlocalidad_org { get; set; }
        public string localidad_org { get; set; }
        public string cp_org { get; set; }
        public string tfno_org { get; set; }
        public string nif_org { get; set; }
        public string nombre_dst { get; set; }
        public string departamento_dst { get; set; }
        public string calle_dst { get; set; }
        public Nullable<int> codlocalidad_dst { get; set; }
        public string localidad_dst { get; set; }
        public string cp_dst { get; set; }
        public string tfno_dst { get; set; }
        public string nif_dst { get; set; }
        public string tipo_portes { get; set; }
        public string sabado { get; set; }
        public string reembolso { get; set; }
        public Nullable<decimal> valorDecl { get; set; }
        public string provisional { get; set; }
        public string cerrado_punteo { get; set; }
        public Nullable<short> horario { get; set; }
        public string borrado { get; set; }
        public Nullable<short> codpais_org { get; set; }
        public Nullable<short> codprovincia_org { get; set; }
        public Nullable<short> codpais_dst { get; set; }
        public Nullable<short> codprovincia_dst { get; set; }
        public Nullable<short> codplaza_prv { get; set; }
        public Nullable<decimal> kgsvol_prv { get; set; }
        public Nullable<decimal> kgsvol_cli { get; set; }
        public Nullable<decimal> kgsvol_cli_ini { get; set; }
        public Nullable<decimal> kgsvol_cli_red { get; set; }
        public Nullable<decimal> kgsvol_cli_red_ini { get; set; }
        public Nullable<decimal> kgsvol_prv_red_dst { get; set; }
        public Nullable<decimal> kgsvol_prv_red_org { get; set; }
        public short bultos { get; set; }
        public short bultos_ini { get; set; }
        public Nullable<decimal> kgs { get; set; }
        public decimal vol { get; set; }
        public short nexp { get; set; }
        public Nullable<int> codprov_red_dst { get; set; }
        public Nullable<int> codprov_red_org { get; set; }
        public int codcli_red_pag { get; set; }
        public Nullable<int> codcli_may { get; set; }
        public Nullable<int> codcli { get; set; }
        public Nullable<short> codplaza_cli { get; set; }
        public short codmotivo { get; set; }
        public short codplaza_pag { get; set; }
        public short codplaza_dst { get; set; }
        public short codplaza_ano { get; set; }
        public short sec { get; set; }
        public System.DateTime f_anota { get; set; }
        public Nullable<int> codprov { get; set; }
    }
}
