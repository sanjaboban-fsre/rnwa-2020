using System;
using System.Collections.Generic;

namespace ws_1.Models
{
    public partial class Jobs
    {
        public Jobs()
        {
            Employees = new HashSet<Employees>();
        }

        public string JobId { get; set; }
        public string JobTitle { get; set; }
        public decimal? MinSalary { get; set; }
        public decimal? MaxSalary { get; set; }

        public virtual ICollection<Employees> Employees { get; set; }
    }
}
