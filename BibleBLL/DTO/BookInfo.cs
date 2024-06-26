using System;
using System.Collections.Generic;
using System.Text;

namespace BibleBLL.DTO
{
    public class BookInfo
    {
        public int Id { get; set; }
        public TestamentInfo Testament { get; set; }
        public string Name { get; set; }
        public int Position { get; set; }
    }
}
