using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ApiTokenSigner.USBToken
{

    public static class ExtenssionsMethod
    {
        public static float ToFloat(this object x)
        {
            if (x == null)
            {
                return 0;
            }
            var d = Convert.ToDouble(x);
            return float.Parse(Math.Round(d, 5).ToString());
        }

        public static double ToDouble(this object x)
        {
            if (x == null)
            {
                return 0;
            }
            var d = Convert.ToDouble(x);
            var value = string.Format("{0:0.00000}", d);
            return double.Parse(value, System.Globalization.NumberStyles.Float);
        }

        public static int ToInt(this object x)
        {
            if (x == null)
            {
                return 0;
            }

            return Convert.ToInt32(x);
        }

        public static DateTime ToDateTime(this object x)
        {
            if (x == null)
            {
                return DateTime.Now;
            }
            return Convert.ToDateTime(x);
        }

        public static double Round(this object x, int num = 5)
        {
            //num = Sesstion.Setting.Round;
            if (x == null) return 0;
            var s = Math.Round(Convert.ToDouble(x), num);
            return Math.Abs(s);
        }

        public static double ToCurrency(this object me, int num = 5)
        {
            var s = me.ToDouble();
            double mult = System.Math.Pow(10.0, num);
            return (System.Math.Truncate(s * mult) / mult);


        }

        public static IEnumerable<TSource> DistinctBy<TSource, TKey>
                   (this IEnumerable<TSource> source, Func<TSource, TKey> keySelector)
        {
            HashSet<TKey> seenKeys = new HashSet<TKey>();
            foreach (TSource element in source)
            {
                if (seenKeys.Add(keySelector(element)))
                {
                    yield return element;
                }
            }
        }
    }
}
