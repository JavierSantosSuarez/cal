﻿//------------------------------------------------------------------------------
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
    using System.Data.Entity;
    using System.Data.Entity.Infrastructure;
    
    public partial class BDLogEntities : DbContext
    {
        public BDLogEntities()
            : base("name=BDLogEntities")
        {
        }
    
        protected override void OnModelCreating(DbModelBuilder modelBuilder)
        {
            throw new UnintentionalCodeFirstException();
        }
    
        public DbSet<DiaLog> DiaLog { get; set; }
        public DbSet<wsLogLlamadas> wsLogLlamadas { get; set; }
        public DbSet<wsPlaneta> wsPlaneta { get; set; }
        public DbSet<wsProcesaFichero> wsProcesaFichero { get; set; }
        public DbSet<wsTarificador> wsTarificador { get; set; }
    }
}
