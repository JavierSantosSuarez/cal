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
    
    public partial class WasmcomEntities : DbContext
    {
        public WasmcomEntities()
            : base("name=WasmcomEntities")
        {
        }
    
        protected override void OnModelCreating(DbModelBuilder modelBuilder)
        {
            throw new UnintentionalCodeFirstException();
        }
    
        public DbSet<clReclamaciones> clReclamaciones { get; set; }
        public DbSet<clTiposReclamacion> clTiposReclamacion { get; set; }
        public DbSet<clTiposTrackingReclamacion> clTiposTrackingReclamacion { get; set; }
        public DbSet<clTrackingReclamacion> clTrackingReclamacion { get; set; }
        public DbSet<tplazas> tplazas { get; set; }
    }
}
