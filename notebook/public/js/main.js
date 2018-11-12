var ue = false;

main = {
	
	init:function(){
		 ue = UE.getEditor('editor');
		 ue.addListener('keydown', function (type, e) {
		 	var keyCode = e.keyCode;
		 	if(e.ctrlKey && keyCode == 18){
		 		main.tools();
		 	}else if(keyCode == 113){
		 		$id = $('.listName:eq(1)').attr('id');
		 		if($id){
		 				
		 			$url = '?p=index&cqwd=index&a=insertContent'; 
		 			$content = ue.getContent();
	 							
 					$.ajax({		   	
						   type: "GET",
						   url:  $url,
						   data: {"id":$id,"content":$content},
						   dataType:'json',
						   async:true,
						   success: function(msg){
								if(msg == 1){
									$('div[name=topDiv]').hide();
									$('div[name=topDiv]').show(200);
								}						   								
						   }	
				   });

		 			
		 		}
		 	}

		 });
		
	},

	tools:function(){

		$url = '?p=index&cqwd=index&a=getTools';
		$.ajax({		
		   type: "GET",
		   url:  $url,
		   //data: {"id":$uid},
		   dataType:'text',
		   async:true,
		   success: function(msg){
		   		
		   		
		   }
		
		});


	},

	delete:function($uid){

		$url = '?p=index&cqwd=index&a=delete';
		
		$.ajax({		
		   type: "GET",
		   url:  $url,
		   data: {"id":$uid},
		   dataType:'text',
		   async:true,
		   success: function(msg){
		   		
		   		
		   }
		
		});
	},

	update:function($uid,$name){

		$url = '?p=index&cqwd=index&a=update';
		
		$.ajax({		
		   type: "GET",
		   url:  $url,
		   data: {"id":$uid,'name':$name},
		   dataType:'text',
		   async:true,
		   success: function(msg){
		   		if(msg == 1){
		   			$("a[id="+$uid+"][name='append']").text($name);
		   		}
		   }
		
		});
	},

	fetchContent:function($uid){
		
		$url = '?p=index&cqwd=index&a=disContent';
		$content = '';
		$.ajax({		
		   type: "GET",
		   url:  $url,
		   data: {"id":$uid},
		   dataType:'text',
		   async:true,
		   success: function(msg){
		   		
		   		ue.setContent(msg);
		   	
		   }
		
		});
	
	},

	clikcAfunction(){
		
		$('div[name=list]').on('click','a',function(){
			
			$this = $(this);
			$uid = $this.attr('id');

			$name = $('.name').val();

			if($this.attr('name') == 'update'){
				main.update($uid,$name);
				return;
			}	


			if($this.attr('name') == 'delete'){	

				if(window.confirm('你确定要删除吗？')){

					main.delete($uid);
					$this.parent('div').remove();
					return;
					
				}		
				
			}
			
			main.fetchContent($uid);

			$url = '?p=index&cqwd=index&a=disList';
			$('.listName:eq(1)').attr('id',$uid);
					
			$('.name').val($this.text());
			
			if($this.nextAll('div').is(":hidden")){
				
				$this.nextAll('div').show();
				
			}else if($this.nextAll('div').length > 0){
				
				$this.nextAll('div').hide();
					
			}else{

				$.ajax({		
			
					   type: "GET",
					   url:  $url,
					   data: {"uid":$uid},
					   dataType:'json',
					   async:true,
					   success: function(msg){

					     	if(msg.length > 0){
								
								for($i = 0; $i < msg.length; $i++){
									
									$id = msg[$i]['id'];
									$name = msg[$i]['name'];
									$this.parent().append("<div style='margin-left:10px'><a href='javascript:void(0)' id="+$id+">"+$name+"</a>&nbsp;<a name='delete' href='javascript:void(0)' id="+$id+">删除</a>&nbsp;<a name='update' href='javascript:void(0)' id="+$id+">修改</a></div>");
								}			     		

					     	}
					   }
						
			   });


			}	

				
		});

	},

	insertList:function(){

		$('.listName').click(function(){
	
			$this = $(this);
			$val = $this.attr('value');
			$name = $('.name').val();
			$uid = $this.attr('id');
			$url = '?p=index&cqwd=index&a=insert';
			if(!$uid){
				$uid = 0;
			}

			if($name == ''){
				alert('名字不能为空');
				return;
			}
				
			$.ajax({		
				
			   type: "GET",
			   url:  $url,
			   data: {"name":$name,"uid":$uid},
			   dataType:'text',
			   async:true,
			   success: function(msg){
			   		
			     	if(msg){
			     		if($uid == 0){		
			     			
			     			$('div[name=list]').append("<div><a name='append' href='javascript:void(0)' id="+msg+">"+$name+"</a>&nbsp;<a name='delete' href='javascript:void(0)' id="+msg+">删除</a>&nbsp;<a name='update' href='javascript:void(0)' id="+msg+">修改</a></div>");
			     		
			     		}else{

			     			$html = "<div style='margin-left:10px'>";
			     			$html += "<a name='append' href='javascript:void(0)' id="+msg+">"+$name+"</a>&nbsp;<a name='delete' href='javascript:void(0)' id="+msg+">删除</a>&nbsp;<a name='update' href='javascript:void(0)' id="+msg+">修改</a></div>";
			     				
			     			$('div[name=list]').find("a[name=append][id="+$uid+"]").parent().append($html);	

			     		}
			     	}
			   }
				
			});

		});
	},	

	
}


$(document).ready(function(){
	main.init();
	main.insertList();
	main.clikcAfunction();	
	
});