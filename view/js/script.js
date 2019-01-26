$(document).ready(function() {

	// taking date from inputs for filters

    var startDateInput,
        endDateInput,
        sellerInput,
        buildingInput;


    $('#start-date').on('change', function () {
        startDateInput = $('#start-date').val();
        changeFilter("dateFrom",startDateInput);
        console.log(startDateInput);
    });

    $('#end-date').on('change', function () {
        endDateInput = $('#end-date').val();
        changeFilter("dateTo",endDateInput);
        console.log(endDateInput);
    });

    $('#seller').on('change', function () {
        sellerInput = $('#seller option:selected').html();
        changeFilter("prod",sellerInput);
        console.log(sellerInput);
    });

    $('#building').on('change', function () {
        buildingInput = $('#building option:selected').html();
        changeFilter("mag",buildingInput);
        console.log(buildingInput);
    });

	$('#report').click(function(){
		$("#content").load('model/report/data.php');
	});
	$('#prihodyKassa').click(function(){
		$("#content").load('model/prihody/kassa/data.php');
	});
    $('#prihodyNal').click(function(){
        $("#content").load('model/prihody/nal/data.php');
    });
    $('#prihodyBeznal').click(function(){
        $("#content").load('model/prihody/beznal/data.php');
    });
    $('#prihodyPerevod').click(function(){
        $("#content").load('model/prihody/perevod/data.php');
    });
    $('#prihodyPredoplata').click(function(){
        $("#content").load('model/prihody/predoplata/data.php');
    });
    $('#rashody').click(function(){
		$("#content").load('model/rashody/data.php');
	});
	$('#vozvraty').click(function(){
		$("#content").load('model/vozvraty/data.php');
	});
	$('#vzp').click(function(){
		$("#content").load('model/vzp/data.php');
	});
    $('#sdano').click(function(){
        $("#content").load('model/sdano/data.php');
    });
	$('#akb').click(function(){
		$("#content").load('model/akb.php');
	});

    getMoney();
    setInterval(getMoney, 1000);

    function changeFilter($type, $value) {
        var filterType = $type;
        var value = $value;
        console.log('change filter');
        $.ajax({
            type: "POST",
            url: "service/changeFilter.php",
            data: {
                filterType : filterType,
				value: value
            },
            async: false,
            success: function ($result) {
                //console.log($result);
                console.log($result);
                $("#content").toggle('model/'+$result+'/data.php');
                $("#content").load('model/'+$result+'/data.php');
                $("#content").toggle('model/'+$result+'/data.php');
            },
            error: function () {
                console.log("change filter ERROR");
            }
        });
    }

    function getMoney(){
        console.log("start money");
        $.ajax({
            type: "POST",
            url: "service/updateMoney.php",
            async: true,
            success: function ($result) {
                //console.log($result);
                console.log("Остаток " + $result);
                $("#money").html($result);
            },
            error: function () {
                console.log("Ошибка получения остатка");
            }
        });
    }



        /*    $('.btn-info').click(function () {
                var idValue;
                var modal = "change";
                idValue = $(this).attr('id');
                console.log(idValue);
                $.ajax({
                    type: "POST",
                    url: "view/crud.php",
                    data: {
                        "id" : idValue,
                        "modal" : modal
                    },
                    async: false,
                    success: function ($result) {
                        // console.log($result);
                        $("#modal").html($result);
                        $("#modal").show();
                        console.log("change sucsess");
                    },
                    error: function () {
                        console.log("add data ERROR");
                    }
                });
            });

            $('#addForm').click(function () {
                var modal = "add";
                $.ajax({
                    type: "POST",
                    url: "view/crud.php",
                    data: {
                        "modal" : modal
                    },
                    async: false,
                    success: function ($result) {
                        //console.log($result);
                        $("#modal").html($result);
                        $("#modal").show();
                        console.log("modalAdd completed");
                    },
                    error: function () {
                        console.log("add data ERROR");
                    }
                });
            });


            $("#addClick").click(function (e) {
                e.preventDefault();
                console.log('form add submit clicked');
                var data_review = $(this).serialize();
                console.log($(this));
                $.ajax({
                    type: "POST",
                    url: "view/crud.php",
                    data: data_review,
                   // async: false,
                    success: function () {
                        $("#cancel").click();
                        console.log("add data sucsess");
                    },
                    error: function () {
                        console.log("add data ERROR");
                    }
                });
                console.log("end");
            });*/
});