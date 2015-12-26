<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Parser;
use Input;
use Carbon\carbon;
use App\Products;

class PdfParserController extends Controller
{
  
  public function listPdf(){

    $pdfs = \DB::table('retailers')
        // ->select('retailers.id','products.product_name','products.product_price','products.product_brand','products.product_rating','products.product_reviews','products.picture_link','products.shopper_link','products.category_id', 'retailers.picture_link as retailer_picture' )
        ->join('pdf', 'retailers.id', '=', 'pdf.retailer_id')
        ->join('crawler', 'pdf.crawler_id', '=', 'crawler.id')
        ->select('pdf.id','pdf.pricelist_file','pdf.crawler_id', 'pdf.retailer_id','retailers.retailer_name', 'retailers.retailer_email', 'retailers.retailer_site')
        ->get();

    return $pdfs;

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function StartExtractPdf(Request $request, $pdfid, $retailername){
        $pdfs = \DB::table('pdf')
          ->where('id','=', $pdfid)->get();

        foreach ($pdfs as $pdf_url) {
          
          $parser = new \Smalot\PdfParser\Parser();
          $pdf    = $parser->parseFile($pdf_url->pricelist_file);  //method called from Parser.php
          // $text = $pdf->getSectionsText();
          $text = $pdf->getText(); //method called from Object.php

          $toReplace = array('&', ',', '"','\r\n','Price','Q uad', 'M icro', 'M aximus','D D R3');
          $with = array('-','_','inch',' ', 'Price ', 'Quad', 'Micro','Maximus', 'DDR3');
          $string  =  str_replace($toReplace, $with, $text);
          $new = trim(preg_replace('/\n/', ' ', $string));
          $filename = strtolower($retailername)."-pricelist-pdf.txt";

          $myfile = fopen(public_path()."/file/".$filename, "w") or die("Unable to open file!");


          fwrite($myfile, $new);
          fclose($myfile);
          if(  $myfile) return '<div class="alert alert-success">successfully extract data from pdf</div>';
        }

        return '<div class="alert alert-danger">failed to extract data from pdf</div>';

    }

    public function ProcessDataPdf($retailer){

      // return $retailer;
      if(strcasecmp( $retailer, 'cycom' ) == 0){
        return $this->cycomExtractor($retailer);
      }
      else{
        return $this->czoneExtractor($retailer);
      }

    }

    private function cycomExtractor($retailer){

       $pricelist_filter = fopen(public_path().'/file/pricelist-filter/'.$retailer."-filter.txt", 'r') or die('Unable to open file!');
       // Output one line until end-of-file
       $products_list = [];

       while(!feof($pricelist_filter)) {
         $line = fgets($pricelist_filter);
         $line = trim($line, ";");
         $tokens = explode(";",$line);

           $replace =   array("+", "/", "(", ")", "|", ",\r\n", ",","-","!");
           $toReplace = array("\+","\/","\(","\)","\|",""      ,"","\-","\!");

           $product =  str_replace($replace, $toReplace, $tokens);
         // Append the line array.
         $products_list[] = $product;
       }
       fclose($pricelist_filter);

       $products = [];
       $index = 1;
        foreach($products_list as $product){

            $pricelist_pdf = fopen(public_path()."/file/".$retailer."-pricelist-pdf.txt", "r") or die("Unable to open file!");
            // Output one line until end-of-file

            while(!feof($pricelist_pdf)) {

                if(preg_match('/'.$product[2].'(.*?)([\d]+)/', fgets($pricelist_pdf), $match )){

                    $replace = array('\+','\/','\(','\)','\|','\-','\!');
                    $toReplace = array('+','/','(',')','|','-','!');

                    $_product =  str_replace($replace, $toReplace, $product);

                    $products[]= array($index,$_product[0], $_product[1], str_replace($_product[2], '',$match[0]));
                    
                
                }
            }
            fclose($pricelist_pdf);
            $index++;
        }

         $update_pid = "";
         
          
         foreach($products as list($index, $product, $product_name, $price)){
            $product_spread = explode(' ', strtolower($product));
            // dd($product_spread);

           
            //filter brand from database with spread product name

            $brands = \DB::table('brand'); 
            foreach ($product_spread as $spread) {
              $brands->orWhere('brand_title', 'LIKE' , $spread);
            }
            $brands = $brands->distinct()->get();  

  
    
            $product_brand = "";
            if($brands){
              //if filter brand match with product name.....
              foreach ($brands as $brand) {
                $product_brand = $brand->id;              
              }  
            }else{
              //if filter brand not match with product name set as brand:other.....
                $product_brand = 1;   
            }
            

              //default picture

           
            $pricefilter = $this->priceFilter($product_name, $product);
            if($pricefilter){ 
              //return true, add product to database
              $new_product = new Products;
              $new_product->product_name = $product_name.' '.$product;
              $new_product->product_price = $price;
              $new_product->product_price_temp = $price;
              $new_product->product_rating = 0;
              $new_product->product_reviews = 0;
              $new_product->condition_id = 1;
              $new_product->brand_id = $product_brand;
              $new_product->category_id = 1;
              $new_product->created_at = Carbon::now();
              $new_product->updated_at = Carbon::now();
              $new_product->save();
            }else{
              //return false, update product price only
              
              
            }
           // $update_pid = $update_pid.$pricefilter;

            
        }

        echo "<div class='alert alert-success'>Successfully process pdf data</div>";
    }

    private function czoneExtractor($retailer){
      $myfile = fopen(public_path().'/file/pricelist-filter/'.$retailer.'-filter.txt', 'r') or die('Unable to open file!');
        // Output one line until end-of-file
        $arrProduct = [];

        while(!feof($myfile)) {
          $line = fgets($myfile);
          $line = trim($line, ';');
          $tokens = explode(';',$line);

            $replace =   array('+', '/', '(', ')', '|', ',\r\n', ',','-','!');
            $toReplace = array('\+','\/','\(','\)','\|',''      ,'','\-','\!');

            $product =  str_replace($replace, $toReplace, $tokens);
          // Append the line array.
          $arrProduct[] = $product;
        }

        fclose($myfile);


        $productPrice = [];
        $index = 1;
        foreach($arrProduct as $product){

            $myfile = fopen(public_path().'/file/'.$retailer.'-pricelist-pdf.txt', 'r') or die('Unable to open file!');
            // Output one line until end-of-file

            while(!feof($myfile)) {

                if(preg_match('/\b('.$product[2].').?[\w\.\/]+/', fgets($myfile), $match )){

                    $replace = array('\+','\/','\(','\)','\|','\-');
                    $toReplace = array('+','/','(',')','|','-');

                    $_product =  str_replace($replace, $toReplace, $product[0]);
                    $_product_name =  str_replace($replace, $toReplace, $product[2]);

                    $price = str_replace($_product_name, '', $match[0]);

                    $productPrice[] = array($index , $_product, $_product_name, $product[1], $price);
                }



            }
            fclose($myfile);
            $index++;
        }
        foreach($productPrice as list($index, $product, $product_name, $brand ,$price)){
            echo $index.'[Name :'.$product.' '.$product_name.' ][brand :'.$brand.'  ][price:'.$price.']<br/>';
        }
    }

    private function priceFilter($productname, $productname2){
      $product_name = $productname.' '.$productname2;
      $products = \DB::table('products')
        ->where('product_name', 'LIKE', '%'.$product_name.'%')
        ->get();


      if($products){

        foreach ($products as $product) {
          $updated = Products::findOrFail($product->id);
          $price_temp = $updated->product_price;
          $updated->product_price = 5555555;
          $updated->product_price_temp = $price_temp;
          $updated->updated_at = Carbon::now();
          $updated->save();
        }
        return false;
       
      }
      else{
       return true;
       
      }

      //return false means product exist and should only updated the price while
        //return true means product not exist and should add the whole product details to database 
    }


}
