
<!DOCTYPE html>
<html lang="pl">
	<head>
			<meta charset="utf-8">
	    <title>mcburger toplista</title>
	    <script src="jquery-1.11.1.min.js"></script>
	    <style>
	        h1, h2, .center{
	            text-align: center;
	        }
	    </style>
	</head>
	<body>
    <h1>Top 30</h1>
    <h2>Konkurs McBurger</h2>
<?php
//    require('phpquery/phpQuery/phpQuery.php');


//    $doc = phpQuery::newDocument($html);
//    $doc['']

    $html = file_get_contents("http://mojburger.mcdonalds.pl/services/burgers/?startIndex=0&startId=&total=30&sortBy=popular&direction=-1&keyword=&theme=");
    $html = substr($html, 3);
    //    echo $html;
    $json = json_decode($html);

    $totalRows = $json->totalRows;
    echo '<div class="center"> <button onclick="refreshHits();">total: ' . $totalRows . '</button> <button onclick="placement();">Oblicz miejsce</button></div>';
?>
    <table border="1" align="center">
        <thead>
            <tr>
                <th>id</th>
                <th>głosów</th>
                <th>burger</th>
                <th>imię</th>
                <th>nazwisko</th>
                <th>miasto</th>
                <th>miejsce</th>
            </tr>
        </thead>
        <tbody>

<?php
//    var_dump($json);
    $rows = $json->rows;
    foreach ($rows as $key => $burger){
        $firstName = $burger->firstName;
        $lastName = $burger->lastName;
        $id = $burger->id;
        $title = $burger->title;
        $location = $burger->location;

?>
    <tr>
        <td><?php echo $id; ?></td>
        <td><span id="counter-<?php echo $id; ?>" data-id="<?php echo $id; ?>" class="counter"> </span></td>
        <td><?php echo $title; ?></td>
        <td><?php echo $firstName; ?></td>
        <td><?php echo $lastName; ?></td>
        <td><?php echo $location; ?></td>
        <td>.</td>
    </tr>
<?php
    }

?>

        </tbody>
    </table>


<?php
//    var_dump($json);
?>

<script>
    $(document).ready(function(){
        refreshHits();
    });

    function refreshHits(){
        $('.counter').each(function(){
            var counter = $(this);
            counter.append('[...]');
            $.ajax({
                url: 'hits.php',
                type: 'get',
                dataType: 'html',
                data: {
                    q: counter.attr('data-id')
                },
                success: function(html){
                    counter.html(html);
                },
                failure: function(){
                    counter.html('[error]');
                }
            });
        });
    }

    function placement(){
        var hitsAll = [];
        $('tr').each(function(){
        	var hits = $(this).find('td span').html();
        	hits = parseInt(hits);
        	//console.log(hits);
        	hitsAll.push(hits);
        })
        var index = 0;
        $('tr').each(function(){
        	var hits = $(this).find('td span').html();
        	var before = 0;
        	for (var hitIndex in hitsAll){
        		if (hits <= parseInt(hitsAll[hitIndex])){
        			++before;
        		}
        	}
        	console.log(before);
        	$('tr:eq(' + index + ') td:eq(6)').html(before);
        	++index;
        })
    }
</script>

</body>
</html>