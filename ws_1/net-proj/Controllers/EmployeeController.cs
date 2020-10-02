using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;
using ws_1.Models;

namespace ws_1.Controllers
{
    [ApiController]
    [Route("employee")]
    public class EmployeeController : ControllerBase
    {
        private readonly hrContext _context;

        public EmployeeController(hrContext context)
        {
            _context = context;
        }

        public class EmployeeVM
        {
            [Key]
            public int employee_id { get; set; }
            public string first_name { get; set; }
            public string last_name { get; set; }
            public string department_name { get; set; }
            public int min_salary { get; set; }
            public int max_salary { get; set; }
        };

        [HttpGet("{id}")]
        public ActionResult GetHistoryByEmployeeId(int id)
        {
            string query = @$"
             SELECT e.employee_id, first_name, last_name, department_name, min_salary, max_salary
             FROM employees e
                     INNER JOIN departments d on e.department_id = d.department_id
                     INNER JOIN jobs j on e.job_id = j.job_id
                     INNER JOIN job_history jh on e.employee_id = jh.employee_id
             WHERE e.employee_id = {id}
             ORDER BY start_date DESC 
            ";

            if (_context.Employees.Where(x => x.EmployeeId == id).FirstOrDefault() == null)
                return StatusCode(404, new { message = "Employee does not exist!" });

            var data = _context.EmployeeVM.FromSqlRaw(query).ToList();

            return Ok(data);
        }
    }
}
