<br>
<p style="color:brown"> 
   @if($the_final_Balance >0)
   مدين ب ({{ $the_final_Balance*1 }}) جنيه  
   @elseif ($the_final_Balance <0)
   دائن ب ({{ $the_final_Balance*1*(-1) }})   جنيه
   @else
   متزن
   @endif
</p>