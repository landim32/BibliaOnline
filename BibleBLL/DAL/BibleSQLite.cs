using BibleBLL.DTO;
using System;
using System.Collections.Generic;
using System.Data.SQLite;
using System.Text;

namespace BibleBLL.DAL
{
    public class BibleSQLite
    {
        private string _Filenane = string.Empty;
        private const string LIST_BOOK = @"
            SELECT
               L.liv_id id,
               T.tes_id testamento_id,
               T.tes_nome testamento_nome,
               L.liv_nome livro_nome,
               L.liv_posicao livro_posicao
            FROM livros L
            JOIN testamentos T ON T.tes_id = L.liv_tes_id
            ORDER BY T.tes_id, liv_posicao
        ";

        public BibleSQLite(string fileName)
        {
            _Filenane = fileName;
        }

        private SQLiteConnection DbConnection()
        {
            var cnn = new SQLiteConnection("Data Source=" + _Filenane + "; Version=3;");
            cnn.Open();
            return cnn;
        }

        public IList<BookInfo> ListBook()
        {
            var dbs = new List<BookInfo>();
            using (var cnn = DbConnection()) {
                using (var cmd = cnn.CreateCommand())
                {
                    cmd.CommandText = LIST_BOOK;
                    using (var rd = cmd.ExecuteReader())
                    {
                        while (rd.Read())
                        {
                            dbs.Add(new BookInfo
                            {
                                Id = rd.GetInt32(0),
                                Testament = new TestamentInfo
                                {
                                    Id = rd.GetInt32(1),
                                    Name = rd.GetString(2)
                                },
                                Name = rd.GetString(3),
                                Position = rd.GetInt32(4)
                            });
                        }
                    }
                }
            }
            return dbs;
        }
    }
}
