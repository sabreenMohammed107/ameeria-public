using Microsoft.Owin.Hosting;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ApiTokenSigner
{
    class Program
    {
        static void Main(string[] args)
        {
            using (WebApp.Start<Startup>("https://localhost:44307"))
            {
                Console.WriteLine("Web Server Is Running.");
                Console.WriteLine("Press Any Key To Quit.");
                Console.ReadLine();
            }
        }
    }
}
