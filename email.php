<?php

require 'init.php';

$therapists = array();
$firstnames = array();
$emails = array();
$jointime = array();
$rating = array();
$timeonplatform = array();

$query = "SELECT distinct tablea_col1, tablea_col2, avg(tablec_col2)::int as avg_tablec_col2, tablea_col3, tablea_col4, avg(tabled_col2)::int as avg_tabled_col2 FROM tablea JOIN tableb on tablea_col1 = tableb_col1  LEFT JOIN tabled on  tabled_col1 = tablea_col1 LEFT JOIN tablec on tablec_col1 = tablea_col1 WHERE tableb_col2 < '2016-12-22 14:42:32-05' OR tablea_col5 < '60' group by tablea_col1";
$result = lib::db_query($query);

while ($row = pg_fetch_assoc($result))
{

  array_push($therapists, $row['table1_col1']);
  array_push($firstnames, $row['tablea_col3']);
  array_push($emails, $row['tablea_col4']);
  array_push($timeonplatform, $row['avg_tablec_col2']);
  array_push($jointime, $row['tablea_col2']);
  array_push($rating, $row['avg_tabled_col2']);   
}

foreach ($firstnames as $key => $value) 
{
?>

<html>
  <head>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="css/email.css" rel="stylesheet" type="text/css"/>
  </head>

  <body>
    <div class="emailcontainer">
      <div class="emailitem">
        <div>
          <?php echo $mail_date = date("F j, Y"); ?><br><br>
        </div>

        <div class="emailheader"style="font-size:32px;">
          Try Our Service!
        </div>

        <br>
        <br>
        <i>- Your Friend</i>
        <br>
        <br>

        Dear <?php echo $value; ?>,
        <br>
        <p>
          This is just a reminder that you've signed up as a for test.com. Be sure to let us know your availability so we can get you on the schedule.

          You joined us on <?php echo $jointime[$key]; ?>, and since have spent a total of <?php echo $timeonplatform[$key]; ?> minutes on the platform.
          You're currently rated <?php echo $rating[$key]; ?> out of five. 
        </p>

        <div class="emailitem">
          - Test Team
        </div>
      </div>

      <hr width="80%" align="left"/>

    </div>
  </body>
</html>

<?php } ?>

