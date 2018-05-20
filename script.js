jQuery(document).ready(function($){
	//Удаляем
	$(document).on("click", ".banner-rem-btn", function(){
		var fileName = $(this).data("filename");
		var item = $(this);
		$.ajax({
			  url: 'delete.php',
			  type: 'POST',
			  cache:false,
			  data: {fileName:fileName},
	          type: 'post',
		      success: function(data){
		    	  item.parent().remove();
		      }
		});
	});
	$(document).on('change','#file',function(event){
		event.preventDefault();
		
        var property = document.getElementById('file').files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var isImage = false;
        if(jQuery.inArray(image_extension,['gif','jpg','jpeg','png']) == -1){
          //alert("Неправильный формат");
            isImage = false;
        }else
        {
            isImage = true;
        }

        var form_data = new FormData();
        form_data.append("file",property);
        console.log(form_data);
        $.ajax({
          url:'upload.php?name='+$("input[name=name]").val(),
          method:'POST',
          data:form_data,
          cache:false,
          processData: false,
          contentType: false,
          beforeSend:function(){
            //$('#msg').html('Loading......');
          },
          success:function(data){
	    	  data = JSON.parse(data);
                  var path = './file.png';
                  if(isImage) path = './upload/'+data.fileName;
                  else path = './file.png';
                      var dmain = location.protocol + "//" + location.host;
        	  var photo = `
          	  	<div class="banner-item">
  			  		<span class="banner-rem-btn" data-filename="`+data.fileName+`">x</span>
  			  		<div>
                                    <h6 id='`+data.fileName+`' style='width:100%;position:absolute;top:0%;overflow-x: hidden;opacity:0.0'>`+dmain+`/resources/files/upload/`+data.fileName+`</h6>
                                    <h6 style='width:100%;position:absolute;top:30%;overflow-x: hidden;background-color: rgba(255,255,255,0.8)'>`+data.fileName+`</h6>
                                    <button style='position:absolute;bottom:0%;background-color: rgba(255,255,255,0.7)' onclick="copyToClipboard('`+data.fileName+`')">Копировать ссылку</button>
  			  		<img src='`+path+`'/>
  			  		</div>
                                        <a class="btn btn-success" style='width:80%;margin-top:2px;' href='`+data.fileName+`' download='`+data.fileName+`'>Скачать</a>
  		  		</div>
          	  `;
          	  $("#photo-content").append(photo);
                  $("input[name=name]").val("");
          }
        });
      });
	//Вспомогательные функции
    function baseName (url)
    {   
        if(url != null && url !== undefined)
            return url.substring(url.lastIndexOf('/')+1);
        else
            return url;
    }
    //
});

