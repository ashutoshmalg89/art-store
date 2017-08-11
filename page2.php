<?php 
include 'session.php';

?>
<!DOCTYPE html>
<html>
<head>
<style> 
.flex-container {
    display: -webkit-flex;
    display: flex;  
    -webkit-flex-flow: row wrap;
    flex-flow: row wrap;
    text-align: center;
}

.flex-container > * {
    padding: 15px;
    -webkit-flex: 1 100%;
    flex: 1 100%;
}

header {background: black;color:white;}
footer {background: #aaa;color:white;}

.nav ul {
    list-style-type: none;
  padding: 0;
}

.search{
	border: 1px solid black;
	padding: 50px;
}  

.searchresult{
	width: 75%;
	float: left;
	padding: 15px;
	border: 1px solid black;
}

.logout{
	width: 25%;
	float: left;
	padding: 15px;
	border: 1px solid black;
}
.cart{
	width: 25%;
	float: right;
	padding: 15px;
	border: 1px solid black;
}
</style>


</head>
<body>

<div class="flex-container">
<header>
  <h1> Welcome <?php echo $username?></h1>
  
  <div class="logout">
  	<button onclick="location.href='logout.php';">Logout</button>
  </div>
  <div class="cart">
  <form id='basket' method="POST" action="page3.php">
  <table>
  	<tr>
  	<td>No of Items: </td>
  	<td><?php 
  	include 'connection.php';

  	$qry = $dbh->prepare("select sum(c.number) as item_count from board.shoppingbasket sb, board.contains c 
		where sb.basketid=c.basketid and sb.username='$username'");

  	$qry -> execute();

  	foreach ($qry as $value) {
  		# code...
  		echo $value['item_count'];
  	}

  	?></td>
  	</tr>
  	<tr><td></td><td><input type="submit" name="SBasket" value="ShoppingBasket"></td></tr>
  </table>
  </form>
  </div>
</header>
<div class="search">
	<form id=search method="POST">
	<table>
		<tr><td colspan="3">Search :<input type="text" name="search" id="search"></td></tr>
		<tr>
		<td><input type="submit" name="title" value="SearchByBookTitle"></td>
		<td><input type="submit" name="author" value="SearchByAuthor"></td></form>
		<td><button name="basket" value="basket" onclick="location.href='page4.php';"> Shopping Basket</button></td></tr>
	</table>
	
</div>


<div class="searchresult">
	<?php 
include 'connection.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){

		if(isset($_POST['title'])){
			if($_POST['title'] != ''){

			$searchStr = $_POST['search'];
			$query = $dbh->prepare("select isbn, title, year, price, publisher from board.book where lower(title) like '%$searchStr%'");


			$query -> execute();

			foreach ($query as $row) {
				# code...
				$isbn = $row['isbn'];
				$title = $row['title'];
				$year = $row['year'];
				$price = $row['price'];
				$publisher = $row['publisher'];

				$query1 = $dbh->prepare("select sum(number) as stock_cnt from board.stocks where isbn='$isbn'  group by isbn");

				//$query1 -> debugDumpParams();
				$query1 ->execute();
				foreach($query1 as $res){
				$stock = $res['stock_cnt'];
				}

				

				echo "<form id='AddToCart' action=''  method='POST'>
					  <table border='1'>
						<tr><th>ISBN</th><th>Title</th><th>Year</th><th>Price</th><th>Publisher</th><th>In Stock</th><th>Qty</th><th></th></tr>
						<tr><td>".$isbn."</td>
						<td>".$title."</td>
						<td>".$year."</td>
						<td>".$price."</td>
						<td>".$publisher."</td>
						<td>".$stock."</td>
						<td><input type='text' name='quantity' style='width:25px;'></td>
						<td><input type='submit' value='AddToCart' name='addtocart'></td>
					  </table>
					  </form>";
			}

	
		}
	


		}
		if(isset($_POST['addtocart'])){
			echo $isbn;
		}
}
?>


</div>

<footer></footer>
</div>

</body>
</html>