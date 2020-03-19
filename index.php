<head>
<meta charset="UTF-8">
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>    
<style>
    .ds-btn li{ list-style:none; float:left; padding:10px; }
    .ds-btn li a span{padding-left:15px;padding-right:5px;width:100%;display:inline-block; text-align:left;}
    .ds-btn li a span small{width:100%; display:inline-block; text-align:left;}
    .ds-btn4  {border-radius: 12px;}
</style>
</head>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
	<div class="row">
        <h2>Phayathai IPD System</h2>
        <ul class="ds-btn" id="col-room">
        <!-- <li>
                <a class="btn btn-lg " href="http://dotstrap.com/">
            <i class="glyphicon glyphicon-link pull-left"></i><span>User Profile<br><small>Lorem ipsum dolor</small></span></a> 
                
            </li>
            <li>
                <a class="btn btn-lg btn-primary" href="http://dotstrap.com/">
            <i class="glyphicon glyphicon-user pull-left"></i><span>User Profile<br><small>Lorem ipsum dolor</small></span></a> 
                
            </li>
            <li>
                <a class="btn btn-lg btn-success " href="http://dotstrap.com/">
            <i class="glyphicon glyphicon-dashboard pull-left"></i><span>Dashboard<br><small>Lorem ipsum dolor</small></span></a> 
                
            </li>
            <li>
                <a class="btn btn-lg btn-danger" href="http://dotstrap.com/">
            <i class="glyphicon glyphicon-tasks pull-left"></i><span>Daily Tasks<br><small>Lorem ipsum dolor</small></span></a> 
                
            </li>
            <li>
                <a class="btn btn-lg btn-warning" href="http://dotstrap.com/">
            <i class="glyphicon glyphicon-search pull-left"></i><span>Search<br><small>Lorem ipsum dolor</small></span></a> 
            </li>
            <li>
                <a class="btn btn-lg btn-info" href="http://dotstrap.com/">
            <i class="glyphicon glyphicon-list pull-left"></i><span>List Group<br><small>Lorem ipsum dolor</small></span></a> 
            </li> -->
        </ul>
	</div>
</div>
<script language="javascript">
    xhr = new XMLHttpRequest();
    $(document).ready(function() {
        var abc = [];
        $.ajax({
            url: 'http://freewillmdc.loginto.me:56870/phayathai/api/view.php',
            // url: 'https://mysososo.000webhostapp.com/phayathai/api/view.php',
            // url: 'http://10.32.11.72:7777/phayathai/api/view.php',
            type: 'POST',
            datatype: 'json',
            success: function(data) {
                var HttpCode = data['head']['code'];
                // alert("Success : " + data['body']['room'][0] );
                if(HttpCode=200)
                {
                    var room_list = data['body']['room'];
                    var numRoom_list = room_list.length;
                    for (i = 0; i < numRoom_list; i++)
                    {
                        console.log(data['body']['room'][i]);
                        var data_room = data['body']['room'][i];
                        var data_room_title = data_room['room_title'];
                        var data_nurse = data['body']['room'][i]['nurse_list'];
                        var count_nurse = data_nurse.length;
                        
                        // for (j = 0; j < count_nurse; j++)
                        // {
                        //     var label2 = data_nurse[j]['mac_address'];
                        //     console.log(label2);
                        //     if( typeof(abel2)!="undefined" )
                        //     {
                        //         var label2 = data_nurse[j]['mac_address'].'<br>';
                        //     }
                        //     else
                        //     {
                        //         var label2 = '';
                        //     }
                            
                        // }

                        if(count_nurse>0)
                        {
                            // var icon = "<i class='glyphicon glyphicon-user pull-left'></i>";
                            var icon = "<img alt='Nurse' src='png/nurse.png' style='width:60px;height:60px;'></img>";
                            var aclass = "btn btn-lg btn-warning";
                            var label = "พยาบาลกำลังปฏิบัติงาน";
                            var nurse_label = [];
                            for (j = 0; j < count_nurse; j++)
                            {
                                var nurse_label += data_nurse[j]['mac_address'];
                                console.log(nurse_label);
                            }
                        }
                        else
                        {
                            // var icon = "<i class='glyphicon glyphicon-tag pull-left'></i>";
                            var icon = "<img alt='รูปคนไข้' src='png/bed.png' style='width:60px;height:60px;'></img>";
                            var aclass = "btn btn-lg btn-success";
                            var label = "คนไข้กำลังพักผ่อน";
                            var label2 = '<br>';
                        }                        
                    
                        abc += "<li class='ds-btn4'> <a class='"+aclass+"' href='#'><center>"+icon+"</center><span>"+data_room_title+"<br><small>"+label+"<br>"+label2+"</small></span></a> </li>";
                    }
                    $("#col-room").html(abc);
                    
                }
                else
                {
                    $("#col-room").hide();  
                }
            },
            error: function() { alert('Failed : ' + data['head']['code']); },
            beforeSend: setHeader       
        });   
        });
        function setHeader(xhr) {
        xhr.setRequestHeader('Authorization', 'Phayathai');
    
    }
    
    </script>