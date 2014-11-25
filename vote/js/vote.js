$(document).ready(function(){
	
	fetchimage();
	
});  


$(function(){
	$('.up').on('click',function(){
		var pic_id=$('.img').attr('data-id');
		var user_id=1;
		
		doAction(''+pic_id+'','up',''+user_id+'');
		
	});
	
	$('.down').on('click',function(){
		var pic_id=$('.img').attr('data-id');
		var user_id=1;
		doAction(''+pic_id+'','down',''+user_id+'');
	});
});




function doAction(pic_id,type,user_id){
        $.post('doajax.php',{pic_id:pic_id,type:type,user_id:user_id},function(data){
            if(isNaN(parseFloat(data))){
            	alert("already voted this");
            	$('.box').slideUp(100);
            	
            	fetchimage();
                
                
            }
            else{
            	
            	var vote= $('.votes');
                        vote.fadeOut(100).text(data).fadeIn(200);
                        $('.box').slideUp(1000);
                        fetchimage();
                    	
                }
            });
        
     
        
    }
function fetchimage(){
	var user_id=1;
	  $.getJSON('getimage.php',{user_id:user_id},function(json){
			if(json.id==null){
				 
				 votes.text("");
				 alert("you are already voted on all pics thx!!!");
				 return false;
			}
		 
		var image=$('.img');
		var votes=$('.votes');
		var html='<img class="img-responsive  img-border img-full" src="../imgg/'+json.name+'" alt="" id="image">';
		image.attr('data-id',json.id);
		
		image.fadeOut(1000);
	    votes.text(json.vote);
		image.fadeIn(3000).html(html);
		$('.box').slideDown();
		//when all picture are voted by a user
	
	  });
  }
  
