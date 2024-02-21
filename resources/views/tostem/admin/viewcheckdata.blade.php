<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Check Data</h2>

<?php
$data_compare = [];
$mol = new \App\Models\CheckData();

$data_check_insert_dumy = [];

$data2 = $mol->_get_data2();


?>

<table>
     
  <tr>
    <th>Selling Table</th>
    <th>Price Table</th>
    <th>Selling code </th>
    <th>Design code </th>
    <th>Product Name EN </th>
    <th>Spec1 Name EN </th>
    <th>Ctg Name EN </th>
    <th>Flag </th>
  </tr>
  
  <?php
  
  foreach ($mol->_get_data1() as $ds){
        foreach ($ds as $d){
               
                 $check = 'Unmatch';   
                 $design_price = '';   
                 $price_table = '';   
                  

                $key_search = array_search($d->selling_code, array_column($data2, 'design'));
            
                    if($key_search !== false){
                             $check = 'Match';
                             $design_price = $data2[$key_search]['design'];
                             $price_table = $data2[$key_search]['table_name'];
                             $data_compare[] = $key_search;
                                 
                    }
                if($d->table_name == 'm_selling_code' && $key_search === false){
                     $data_check_insert_dumy[] = $d->selling_code;
                }    
             
  ?>
  <tr>
    <td>{{ $d->table_name }}</td>
    <td>{{ $price_table }}</td>
    <td>{{ $d->selling_code }}</td>
    <td>{{ $design_price }}</td>
    <td>{{ $d->product_name }}</td>
    <td>{{ $d->spec_name }}</td>
    <td>{{ $d->ctg_name }}</td>
    <td>{{ $check }}</td>
  </tr>
  
<?php
        }
  }

  
  
  $key_2 = array_keys($data2);
  
  $compare = array_diff($key_2,$data_compare);
  if(count($compare) > 0){
       foreach ($compare as $k){
            
                 $check = 'Unmatch';   
                 $design_price = $data2[$k]['design'];
                 $price_table = $data2[$k]['table_name'];
            
            
            
?>
  
 <tr>
    <td></td>
    <td>{{ $price_table }}</td>
    <td></td>
    <td>{{ $design_price }}</td>
    <td></td>
    <td></td>
    <td></td>
    <td>{{ $check }}</td>
 </tr>
  
 <?php
        }
  }
  
  //$mol->_insert_data_dummy($data_check_insert_dumy);
 ?>
</table>

</body>
</html>

