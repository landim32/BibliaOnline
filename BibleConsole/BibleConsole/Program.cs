using BibleBLL.DAL;
using System;

namespace BibleConsole
{
    class Program
    {
        private static readonly string FILENAME = @"C:\Git\BibliaOnline\sql\Biblia.db"; 
        private static BibleSQLite _db;

        private static void ListCommands()
        {
            Console.WriteLine("----------------------------");
            Console.WriteLine("1 - List all testaments");
            Console.WriteLine("2 - List all books");
            Console.WriteLine("3 - List versicles by number");
            Console.WriteLine("----------------------------");
        }

        private static void ListAllBooks()
        {
            foreach (var book in _db.ListBook())
            {
                Console.WriteLine("{0} - {1}", book.Id, book.Name);
            }

        }

        private static void Main(string[] args)
        {
            _db = new BibleSQLite(FILENAME);
            Console.WriteLine("Bible Open Source v0.2b");
            string cmd = string.Empty;
            do {
                switch (cmd)
                {
                    case "2":
                        ListAllBooks();
                        break;
                    default:
                        if (!string.IsNullOrEmpty(cmd))
                        {
                            Console.WriteLine(string.Format("Error: command '{0}' is not valid.", cmd));
                        }
                        break;
                }
                ListCommands();
                Console.Write("Enter Command(Type 'x' to exit): ");
                cmd = Console.ReadLine().ToLower();

            } while (cmd != "x" && cmd != "exit");
        }
    }
}
