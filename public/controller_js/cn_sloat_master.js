$('#max_no_of_banners').on('change',function(){


 var max_no_of_banner = $(this).val();
 if(parseInt(max_no_of_banner) == 3){
 	$('#banner_prize_div_1').show();
	$('#banner_prize_div_2').show();
	$('#banner_prize_div_3').show();
	$('#banner_prize_div_4').hide();
	$('#banner_prize_div_5').hide();
 }if(parseInt(max_no_of_banner) == 4){
 	$('#banner_prize_div_1').show();
	$('#banner_prize_div_2').show();
	$('#banner_prize_div_3').show();
 	$('#banner_prize_div_4').show();
 	$('#banner_prize_div_5').hide();
 }if(parseInt(max_no_of_banner) == 5){
 	$('#banner_prize_div_1').show();
	$('#banner_prize_div_2').show();
	$('#banner_prize_div_3').show();
 	$('#banner_prize_div_4').show();
 	$('#banner_prize_div_5').show();
 }
});