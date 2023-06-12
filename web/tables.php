<?php
  include('server.php');
  
  include('import_export.php');


  $obj = $_GET["obj"];

  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website scholarly</title>
    <link rel="stylesheet" href="style.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="script.js"></script>
    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  </head>
<body>
<div class="nav">
<?php if(isset($_SESSION['username']) and isset($_SESSION['isadmin']) and ($_SESSION['isadmin'] == 0)) {
      $name = $_SESSION['username'];
      echo "<a href='logout.php'>Logout</a>";
      
      echo "<a href='mypage.php'>$name</a>";
      
    }elseif (isset($_SESSION['username']) and isset($_SESSION['isadmin']) and ($_SESSION['isadmin'] == 1)) {
      $name = $_SESSION['username'];
      echo "<a href='logout.php'>Logout</a>";
      
      echo "<a href='adminPage.php'>$name</a>";
    }else {
      echo "<a href='login.php'>Log in</a>";
    }
    ?>
    <a href="homepage.php">Home</a>
</div>

<?php
      // echo $category;
      if ($obj == "authors"){
        $sql = "SELECT * FROM authors ";
        $result=mysqli_query($mysqli,$sql);
          ?>
          <table id="pub-table" align="center" border="1px"">
          <thead>
          <tr>
              <th colspan="5"><h2 style="text-align: center;">Results</h2></th>
          </tr>

          <tr>
              <th>Name<div class="sort-symbol"><></div></th>
              <th>Affiliation<div class="sort-symbol"><></div></th>
              <th>Email_domain<div class="sort-symbol"><></div></th>
              <th>Citations<div class="sort-symbol"><></div></th>
              <th>Link</th>
          </tr>
          </thead>
          <tfoot>
          <tr>
            <th></th> 
            <th></th> 
            <th></th> 
            <th></th>
          </tr>
        </tfoot>
        <tbody>
          <?php
          while($rows=mysqli_fetch_assoc($result))
          {
            $id = $rows['id'];
            $name = $rows['name'];
          ?>
              <tr>
                  <td><?php echo $rows['name']; ?></td>
                  <td><?php echo $rows['affiliation']; ?></td>
                  <td><?php echo $rows['email_domain']; ?></td>
                  <td><?php echo $rows['citations']; ?></td>
                  <td><?php echo "<a href='details.php?id=$id'>$name</a><br>";?></td>
              </tr>
              <?php
          }
          ?>
        </tbody>
      </table>
      
  </body>
  </html>
    <?php }elseif ($obj == "publ") {
      $sql = "SELECT * FROM publications";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table id="pub-table" align="center" border="1px"">
        <thead>
        <tr>
            <th colspan="6"><h2 style="text-align: center;">Results</h2></th>
        </tr>

        <tr>
            <th>Title<div class="sort-symbol"><></div></th>
            <th>Conference<div class="sort-symbol"><></div></th>
            <th>Year<div class="sort-symbol"><></div></th>
            <th>Citations<div class="sort-symbol"><></div></th>
            <th>Rank<div class="sort-symbol"><></div></th>
            <th>Link</th>
        </tr>
        </thead>
        <tfoot>
          <tr>
            <th></th> 
            <th></th> 
            <th></th> 
            <th></th> 
            <th></th>
          </tr>
        </tfoot>

        <tbody>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {
          $id = $rows['id'];
        ?>
            <tr>
                <td><?php echo $rows['title']; ?></td>
                <td><?php echo $rows['conference']; ?></td>
                <td><?php echo $rows['year']; ?></td>
                <td><?php echo $rows['citations']; ?></td>
                <td><?php echo $rows['rank']; ?></td>
                <td><?php echo "<a href='pub-det.php?id=$id'>More information</a><br>";?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    
</body>
</html>

<?php }elseif ($obj == "conferences") {
      $sql = "SELECT * FROM conferences";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table id="pub-table" align="center" border="1px"">
        <thead>
        <tr>
            <th colspan="5"><h2 style="text-align: center;">Results</h2></th>
        </tr>

        <tr>
            <th>Title<div class="sort-symbol"><></div></th>
            <th>Acronym<div class="sort-symbol"><></div></th>
            <th>Year<div class="sort-symbol"><></div></th>
            <th>Rank<div class="sort-symbol"><></div></th>
            <th>Top<div class="sort-symbol"><></div></th>
        </tr>
        </thead>
        <tfoot>
          <tr>
            <th></th> 
            <th></th> 
            <th></th> 
            <th></th> 
            <th></th>
          </tr>
        </tfoot>

        <tbody>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {
        ?>
            <tr>
                <td><?php echo $rows['title']; ?></td>
                <td><?php echo $rows['acronym']; ?></td>
                <td><?php echo $rows['coreyear']; ?></td>
                <td><?php echo $rows['rank']; ?></td>
                <td><?php echo $rows['rank_value']; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    
</body>
</html>

<?php }elseif ($obj == "journalsAIS") {
      $sql = "SELECT * FROM journals WHERE title <> '' ";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table id="pub-table" align="center" border="1px"">
        <thead>
        <tr>
            <th colspan="6"><h2 style="text-align: center;">Results</h2></th>
        </tr>

        <tr>
            <th>Title<div class="sort-symbol"><></div></th>
            <th>ISSN<div class="sort-symbol"><></div></th>
            <th>Subdomain<div class="sort-symbol"><></div></th>
            <th>Rank<div class="sort-symbol"><></div></th>
            <th>Top<div class="sort-symbol"><></div></th>
            <th>Year<div class="sort-symbol"><></div></th>
        </tr>
        </thead>
        <tfoot>
          <tr>
            <th></th> 
            <th></th> 
            <th></th> 
            <th></th> 
            <th></th>
            <th></th>
          </tr>
        </tfoot>

        <tbody>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {
        ?>
            <tr>
                <td><?php echo $rows['title']; ?></td>
                <td><?php echo $rows['ISSN']; ?></td>
                <td><?php echo $rows['subdomeniu']; ?></td>
                <td><?php echo $rows['rank']; ?></td>
                <td><?php echo $rows['Loc_in_zona']; ?></td>
                <td><?php echo $rows['year']; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    
</body>
</html>

  
<?php }elseif ($obj == "journalsIF") {
      $sql = "SELECT * FROM journals_if WHERE title <> '' ";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table id="pub-table" align="center" border="1px"">
        <thead>
        <tr>
            <th colspan="6"><h2 style="text-align: center;">Results</h2></th>
        </tr>

        <tr>
            <th>Title<div class="sort-symbol"><></div></th>
            <th>ISSN<div class="sort-symbol"><></div></th>
            <th>Subdomain<div class="sort-symbol"><></div></th>
            <th>Rank<div class="sort-symbol"><></div></th>
            <th>Top<div class="sort-symbol"><></div></th>
            <th>Year<div class="sort-symbol"><></div></th>
        </tr>
        </thead>
        <tfoot>
          <tr>
            <th></th> 
            <th></th> 
            <th></th> 
            <th></th> 
            <th></th>
            <th></th>
          </tr>
        </tfoot>

        <tbody>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {
        ?>
            <tr>
                <td><?php echo $rows['title']; ?></td>
                <td><?php echo $rows['ISSN']; ?></td>
                <td><?php echo $rows['subdomeniu']; ?></td>
                <td><?php echo $rows['rank']; ?></td>
                <td><?php echo $rows['Loc_in_zona']; ?></td>
                <td><?php echo $rows['year']; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    
</body>
</html>

    <?php }else {
      $sql = "SELECT id,domain FROM domains";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table id="pub-table" align="center" border="1px"">
        <thead>
        <tr>
            <th colspan="2"><h2 style="text-align: center;">Results</h2></th>
        </tr>

        <tr>
            <th>ID<div class="sort-symbol"><></div></th>
            <th>Name<div class="sort-symbol"><></div></th>
        </tr>
        </thead>

        <tfoot>
          <tr>
            <th></th> 
            <th></th> 
          </tr>
        </tfoot>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {
          $id = $rows['id'];
          $domain = $rows['domain'];
        ?>
            <tr>
                <td><?php echo $rows['id']; ?></td>
                <td><?php echo $rows['domain']; ?></td>
            <?php
        } } 
        ?>
    </table>
    <div class="buttons">
        <h3>Export options</h3>
        <form action="mypage.php" method="post" >
        
        <select name="export-select">
            <option value="Authors">Authors</option>
            <option value="Publications">Publications</option>
            <option value="Domains">Domains</option>
            <option value="Conferences">Conferences</option>
            <option value="JournalsAIS">Journals AIS</option>
            <option value="JournalsIF">Journals IF</option>
        </select>
            <input type="submit" class="btn-submit" name="eCSV" value="Export CSV">
            <input type="submit" class="btn-submit" name="eJSON" value="Export JSON">
        </form>
    </div>
    <script>
    $(document).ready(function() {
      $('#pub-table').DataTable({
        columnDefs: [
          { targets: '_all', orderable: true }, // Enable sorting on all columns
        ],
        searching: true,
        initComplete: function() {
          this.api().columns().every(function() {
            var column = this;
            var input = $('<input type="text">').on('keyup change', function() {
              column.search($(this).val()).draw();
            });
            $(column.footer()).html(input);
          });
        },
        "language": {
        "paginate": {
          "first": "&laquo;",
          "last": "&raquo;",
          "previous": "&lsaquo;",
          "next": "&rsaquo;"
        }
        }
      });
    });
  </script>
</body>
</html>
