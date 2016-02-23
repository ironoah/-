
#include <time.h>
#include <stdio.h>
#include <windows.h>

int _tmain(int argc, _TCHAR* argv[])
{
   time_t time1, time2;
   long l;

   time(&time1);

   //for (l=0; l<100000000; l++);
   Sleep(12340);

   time(&time2);
   printf("経過時間: %6f秒\n", difftime(time2,time1));

   return 0;
}
