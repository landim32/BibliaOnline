using System;
using System.Collections.Generic;
using System.Data.SQLite;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BibliaCriarDB
{
    public class DalHelper
    {
        private const string SQLITE_FILENAME = @"c:\Git\BibliaOnline\Biblia.sqlite";

        public SQLiteConnection DbConnection()
        {
            var cnn = new SQLiteConnection("Data Source=" + SQLITE_FILENAME + "; Version=3;");
            cnn.Open();
            return cnn;
        }

        public void CriarDB()
        {
            SQLiteConnection.CreateFile(SQLITE_FILENAME);
        }


    }
}
