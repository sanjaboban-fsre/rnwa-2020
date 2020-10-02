using System;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Metadata;

namespace ws_1.Models
{
    public partial class hrContext : DbContext
    {
        public hrContext()
        {
        }

        public hrContext(DbContextOptions<hrContext> options)
            : base(options)
        {
        }

        public virtual DbSet<Countries> Countries { get; set; }
        public virtual DbSet<Departments> Departments { get; set; }
        public virtual DbSet<EmpDetailsView> EmpDetailsView { get; set; }
        public virtual DbSet<Employees> Employees { get; set; }
        public virtual DbSet<JobHistory> JobHistory { get; set; }
        public virtual DbSet<Jobs> Jobs { get; set; }
        public virtual DbSet<Locations> Locations { get; set; }
        public virtual DbSet<Regions> Regions { get; set; }

        public virtual DbSet<Controllers.EmployeeController.EmployeeVM> EmployeeVM { get; set; }

        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            if (!optionsBuilder.IsConfigured)
            {
                optionsBuilder.UseMySQL("server=127.0.0.1;port=3306;user=root;password=root;database=hr");
            }
        }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Countries>(entity =>
            {
                entity.HasKey(e => e.CountryId)
                    .HasName("PRIMARY");

                entity.ToTable("countries");

                entity.HasIndex(e => e.RegionId)
                    .HasName("region_id");

                entity.Property(e => e.CountryId)
                    .HasColumnName("country_id")
                    .HasMaxLength(2)
                    .IsFixedLength();

                entity.Property(e => e.CountryName)
                    .HasColumnName("country_name")
                    .HasMaxLength(40)
                    .IsUnicode(false);

                entity.Property(e => e.RegionId)
                    .HasColumnName("region_id")
                    .HasColumnType("int unsigned");

                entity.HasOne(d => d.Region)
                    .WithMany(p => p.Countries)
                    .HasForeignKey(d => d.RegionId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("countries_ibfk_1");
            });

            modelBuilder.Entity<Departments>(entity =>
            {
                entity.HasKey(e => e.DepartmentId)
                    .HasName("PRIMARY");

                entity.ToTable("departments");

                entity.HasIndex(e => e.LocationId)
                    .HasName("location_id");

                entity.HasIndex(e => e.ManagerId)
                    .HasName("manager_id");

                entity.Property(e => e.DepartmentId)
                    .HasColumnName("department_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.DepartmentName)
                    .IsRequired()
                    .HasColumnName("department_name")
                    .HasMaxLength(30)
                    .IsUnicode(false);

                entity.Property(e => e.LocationId)
                    .HasColumnName("location_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.ManagerId)
                    .HasColumnName("manager_id")
                    .HasColumnType("int unsigned");

                entity.HasOne(d => d.Location)
                    .WithMany(p => p.Departments)
                    .HasForeignKey(d => d.LocationId)
                    .HasConstraintName("departments_ibfk_1");

                entity.HasOne(d => d.Manager)
                    .WithMany(p => p.Departments)
                    .HasForeignKey(d => d.ManagerId)
                    .HasConstraintName("departments_ibfk_2");
            });

            modelBuilder.Entity<EmpDetailsView>(entity =>
            {
                entity.HasNoKey();

                entity.ToView("emp_details_view");

                entity.Property(e => e.City)
                    .IsRequired()
                    .HasColumnName("city")
                    .HasMaxLength(30)
                    .IsUnicode(false);

                entity.Property(e => e.CommissionPct)
                    .HasColumnName("commission_pct")
                    .HasColumnType("decimal(2,2)");

                entity.Property(e => e.CountryId)
                    .IsRequired()
                    .HasColumnName("country_id")
                    .HasMaxLength(2)
                    .IsFixedLength();

                entity.Property(e => e.CountryName)
                    .HasColumnName("country_name")
                    .HasMaxLength(40)
                    .IsUnicode(false);

                entity.Property(e => e.DepartmentId)
                    .HasColumnName("department_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.DepartmentName)
                    .IsRequired()
                    .HasColumnName("department_name")
                    .HasMaxLength(30)
                    .IsUnicode(false);

                entity.Property(e => e.EmployeeId)
                    .HasColumnName("employee_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.FirstName)
                    .HasColumnName("first_name")
                    .HasMaxLength(20)
                    .IsUnicode(false);

                entity.Property(e => e.JobId)
                    .IsRequired()
                    .HasColumnName("job_id")
                    .HasMaxLength(10)
                    .IsUnicode(false);

                entity.Property(e => e.JobTitle)
                    .IsRequired()
                    .HasColumnName("job_title")
                    .HasMaxLength(35)
                    .IsUnicode(false);

                entity.Property(e => e.LastName)
                    .IsRequired()
                    .HasColumnName("last_name")
                    .HasMaxLength(25)
                    .IsUnicode(false);

                entity.Property(e => e.LocationId)
                    .HasColumnName("location_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.ManagerId)
                    .HasColumnName("manager_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.RegionName)
                    .HasColumnName("region_name")
                    .HasMaxLength(25)
                    .IsUnicode(false);

                entity.Property(e => e.Salary)
                    .HasColumnName("salary")
                    .HasColumnType("decimal(8,2)");

                entity.Property(e => e.StateProvince)
                    .HasColumnName("state_province")
                    .HasMaxLength(25)
                    .IsUnicode(false);
            });

            modelBuilder.Entity<Employees>(entity =>
            {
                entity.HasKey(e => e.EmployeeId)
                    .HasName("PRIMARY");

                entity.ToTable("employees");

                entity.HasIndex(e => e.DepartmentId)
                    .HasName("department_id");

                entity.HasIndex(e => e.JobId)
                    .HasName("job_id");

                entity.HasIndex(e => e.ManagerId)
                    .HasName("manager_id");

                entity.Property(e => e.EmployeeId)
                    .HasColumnName("employee_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.CommissionPct)
                    .HasColumnName("commission_pct")
                    .HasColumnType("decimal(2,2)");

                entity.Property(e => e.DepartmentId)
                    .HasColumnName("department_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.Email)
                    .IsRequired()
                    .HasColumnName("email")
                    .HasMaxLength(25)
                    .IsUnicode(false);

                entity.Property(e => e.FirstName)
                    .HasColumnName("first_name")
                    .HasMaxLength(20)
                    .IsUnicode(false);

                entity.Property(e => e.HireDate)
                    .HasColumnName("hire_date")
                    .HasColumnType("date");

                entity.Property(e => e.JobId)
                    .IsRequired()
                    .HasColumnName("job_id")
                    .HasMaxLength(10)
                    .IsUnicode(false);

                entity.Property(e => e.LastName)
                    .IsRequired()
                    .HasColumnName("last_name")
                    .HasMaxLength(25)
                    .IsUnicode(false);

                entity.Property(e => e.ManagerId)
                    .HasColumnName("manager_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.PhoneNumber)
                    .HasColumnName("phone_number")
                    .HasMaxLength(20)
                    .IsUnicode(false);

                entity.Property(e => e.Salary)
                    .HasColumnName("salary")
                    .HasColumnType("decimal(8,2)");

                entity.HasOne(d => d.Department)
                    .WithMany(p => p.Employees)
                    .HasForeignKey(d => d.DepartmentId)
                    .HasConstraintName("employees_ibfk_2");

                entity.HasOne(d => d.Job)
                    .WithMany(p => p.Employees)
                    .HasForeignKey(d => d.JobId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("employees_ibfk_1");

                entity.HasOne(d => d.Manager)
                    .WithMany(p => p.InverseManager)
                    .HasForeignKey(d => d.ManagerId)
                    .HasConstraintName("employees_ibfk_3");
            });

            modelBuilder.Entity<JobHistory>(entity =>
            {
                entity.HasNoKey();

                entity.ToTable("job_history");

                entity.HasIndex(e => e.DepartmentId)
                    .HasName("department_id");

                entity.HasIndex(e => e.JobId)
                    .HasName("job_id");

                entity.HasIndex(e => new { e.EmployeeId, e.StartDate })
                    .HasName("employee_id")
                    .IsUnique();

                entity.Property(e => e.DepartmentId)
                    .HasColumnName("department_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.EmployeeId)
                    .HasColumnName("employee_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.EndDate)
                    .HasColumnName("end_date")
                    .HasColumnType("date");

                entity.Property(e => e.JobId)
                    .IsRequired()
                    .HasColumnName("job_id")
                    .HasMaxLength(10)
                    .IsUnicode(false);

                entity.Property(e => e.StartDate)
                    .HasColumnName("start_date")
                    .HasColumnType("date");

                entity.HasOne(d => d.Department)
                    .WithMany()
                    .HasForeignKey(d => d.DepartmentId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("job_history_ibfk_3");

                entity.HasOne(d => d.Employee)
                    .WithMany()
                    .HasForeignKey(d => d.EmployeeId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("job_history_ibfk_1");

                entity.HasOne(d => d.Job)
                    .WithMany()
                    .HasForeignKey(d => d.JobId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("job_history_ibfk_2");
            });

            modelBuilder.Entity<Jobs>(entity =>
            {
                entity.HasKey(e => e.JobId)
                    .HasName("PRIMARY");

                entity.ToTable("jobs");

                entity.Property(e => e.JobId)
                    .HasColumnName("job_id")
                    .HasMaxLength(10)
                    .IsUnicode(false);

                entity.Property(e => e.JobTitle)
                    .IsRequired()
                    .HasColumnName("job_title")
                    .HasMaxLength(35)
                    .IsUnicode(false);

                entity.Property(e => e.MaxSalary)
                    .HasColumnName("max_salary")
                    .HasColumnType("decimal(8,0) unsigned");

                entity.Property(e => e.MinSalary)
                    .HasColumnName("min_salary")
                    .HasColumnType("decimal(8,0) unsigned");
            });

            modelBuilder.Entity<Locations>(entity =>
            {
                entity.HasKey(e => e.LocationId)
                    .HasName("PRIMARY");

                entity.ToTable("locations");

                entity.HasIndex(e => e.CountryId)
                    .HasName("country_id");

                entity.Property(e => e.LocationId)
                    .HasColumnName("location_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.City)
                    .IsRequired()
                    .HasColumnName("city")
                    .HasMaxLength(30)
                    .IsUnicode(false);

                entity.Property(e => e.CountryId)
                    .IsRequired()
                    .HasColumnName("country_id")
                    .HasMaxLength(2)
                    .IsFixedLength();

                entity.Property(e => e.PostalCode)
                    .HasColumnName("postal_code")
                    .HasMaxLength(12)
                    .IsUnicode(false);

                entity.Property(e => e.StateProvince)
                    .HasColumnName("state_province")
                    .HasMaxLength(25)
                    .IsUnicode(false);

                entity.Property(e => e.StreetAddress)
                    .HasColumnName("street_address")
                    .HasMaxLength(40)
                    .IsUnicode(false);

                entity.HasOne(d => d.Country)
                    .WithMany(p => p.Locations)
                    .HasForeignKey(d => d.CountryId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("locations_ibfk_1");
            });

            modelBuilder.Entity<Regions>(entity =>
            {
                entity.HasKey(e => e.RegionId)
                    .HasName("PRIMARY");

                entity.ToTable("regions");

                entity.Property(e => e.RegionId)
                    .HasColumnName("region_id")
                    .HasColumnType("int unsigned");

                entity.Property(e => e.RegionName)
                    .HasColumnName("region_name")
                    .HasMaxLength(25)
                    .IsUnicode(false);
            });

            OnModelCreatingPartial(modelBuilder);
        }

        partial void OnModelCreatingPartial(ModelBuilder modelBuilder);
    }
}
