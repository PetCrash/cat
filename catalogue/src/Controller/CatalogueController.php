<?php
// src/Controller/CatalogueController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Utils\PrestaShopWebservice;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Products;
use App\Entity\Categories;

class CatalogueController extends AbstractController
{
    public function catalogo()
    {
        //Datos de conexión
        $claveAPI = "G8WR4LSASFVPTNQ96CLQ2GG9J7G4RCC8";
        $URL = "http://cms.clickcanarias-sandbox.net/prestashop/1.6";
        $idEmpresa = "3";
        
        //Conexión con el WebService de Prestashop
        $webService = new PrestaShopWebservice($URL, $claveAPI, false);
        
        //Recoger los ID de los productos
        /*$xmlProducts = $webService->get(array('resource' => 'products'));
        $productsId = array();
        foreach ($xmlProducts->products->product as $product)
        {
            $productId =(int) $product->attributes()->id[0]; 
            array_push($productsId, $productId);
        } 
        
        //Recoger los ID de las categorías
        $xmlCategories = $webService->get(array('resource' => 'categories'));
        $categoriesId = array();
        foreach ($xmlCategories->categories->category as $category)
        {
            $categoryId =(int) $category->attributes()->id[0]; 
            array_push($categoriesId, $categoryId);
        }
        
        //Recoger nombre de las categorías y guardarlo en un array
        $categories = array();
        foreach ($categoriesId as $idCategory)
        {
            $xmlInfoCategories = $webService->get(array('resource' => 'categories', 'id' => $idCategory));
            $categories[$idCategory]=(string)$xmlInfoCategories->category->name->language[0];
        }*/
        
        /*//Recoger en un array el valor y los nombres de los impuestos
        $xmlTaxes = $webService->get(array('resource' => 'taxes'))->taxes;
        $taxes = array();
        foreach ($xmlTaxes->tax as $tax)
        {
            $xmlInfoTaxes = $webService->get(array('resource' => 'taxes', 'id' => $tax->attributes()->id));
            $taxName=(array)$xmlInfoTaxes->tax->name->language;
            $taxes[$taxName[0]] = (float)$xmlInfoTaxes->tax->rate;
        }*/
        
        //Buscar país España
        $xmlCountries = $webService->get(array('resource' => 'countries'))->countries;
        $countriesId = array();
        
        foreach ($xmlCountries->country as $country)
        {
            $countryId =(int) $country->attributes()->id[0];
            array_push($countriesId, $countryId);
        }
        $espana= $webService->get(array('resource' => 'countries', 'display' => '[id]', 'filter[iso_code]' => '[ES]'));
        print_r($webService->get(array('resource' => 'tax_rules', 'display' => '[id_tax]', 'filter[id_country]' => '6')));
        /*foreach ($countriesId as $idCountry)
        {
            print_r($idCountry);
            $country = (string)$webService->get(array('resource' => 'countries', 'id' => $idCountry))->country->iso_code;
            if($country == "ES")
            {
                print_r($country);
                break;
            }
            
        }
        //print_r($xmlInfoTaxes);
        
/*
        //Buscar la información de los productos y guardarlos en un array de productos
        $products = array();
        foreach ($productsId as $idProduct)
        {
            $xmlInfoProducts = $webService->get(array('resource' => 'products', 'id' => $idProduct));
            //Buscar en la base de datos si existe el producto
            $em = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Products::class);
            $productoGuardado = $repository->findOneBy(['supplierReference' => $idProduct]);
            $lastUpdate="";
            if($productoGuardado)
            {
                $lastUpdate = $productoGuardado->getDateUpdate();
            }
            
            if(!$productoGuardado)
            {
                $product = array();
                $product['name'] = (string)$xmlInfoProducts->product->name->language[0];
                $product['supplier_reference'] = $idProduct;
                $product['supplier_id'] = $idEmpresa;
                $product['description'] = (string)$xmlInfoProducts->product->description->language[0];
                $product['short_description'] = (string)$xmlInfoProducts->product->description_short->language[0];
                $product['price'] = (float)$xmlInfoProducts->product->price;
                $ivaName = (string)$webService->get(array('resource' => 'tax_rule_groups', 'id' => $xmlInfoProducts->product->id_tax_rules_group))->tax_rule_group->name;
                var_dump($taxes);
                $product['iva'] = $taxes[$ivaName];
                $product['height'] = (float)$xmlInfoProducts->product->height;
                $product['width'] = (float)$xmlInfoProducts->product->width;
                $product['length'] = (float)$xmlInfoProducts->product->length;
                $product['date_update'] = (string)$xmlInfoProducts->product->date_upd;
                $product['categories'] = array();

                foreach ($xmlInfoProducts->product->associations->categories->category as $idProductcategories) 
                {
                    array_push($product['categories'], strtolower($categories[(string)$idProductcategories->id]));
                }
                $product['defaultImage'] = $xmlInfoProducts->product->id_default_image->attributes('xlink', true)->href;
                $arrayDefImage = explode("//", $product['defaultImage']);
                $product['defaultImage'] = $arrayDefImage[1];
                array_push($products, $product);

                // Guardar la imagen por defecto
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $claveAPI."@".$product['defaultImage']);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $imagen = curl_exec($ch);
                curl_close($ch);
                $archivo = @fopen("Images/".$idEmpresa."_".$idProduct."_default.jpg", 'w');
                @fwrite($archivo, $imagen);
                @fclose($archivo);

                //guardar imagenes en directorio
                $img = $xmlInfoProducts->product->associations->images->image;
                $i=0;
                foreach ($img as $image)
                {
                    $i++;
                    $href=(string)$image->attributes('xlink', true)->href;
                    $arrayHref=explode("//", $href);
                    $href = $arrayHref[1];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $claveAPI."@".$href);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $imagen = curl_exec($ch);
                    curl_close($ch);
                    $archivo = @fopen("Images/".$idEmpresa."_".$idProduct."_".$i.".jpg", 'w');
                    if($archivo)
                    {
                        @fwrite($archivo, $imagen);
                        @fclose($archivo);
                    }
                }
            }
            elseif ($lastUpdate < (string)$xmlInfoProducts->product->date_upd) 
            {
                $eManager = $this->getDoctrine()->getManager();
                $productoGuardado->setName((string)$xmlInfoProducts->product->name->language[0]);
                $productoGuardado->setDescription((string)$xmlInfoProducts->product->description->language[0]);
                $productoGuardado->setShortDescription((string)$xmlInfoProducts->product->description_short->language[0]);
                $productoGuardado->setSupplierReference($idProduct);
                $productoGuardado->setSupplierId($idEmpresa);
                $productoGuardado->setDateUpdate((string)$xmlInfoProducts->product->date_upd);
                $productoGuardado->setPrice(round((float)$xmlInfoProducts->product->price, 2));
                $productoGuardado->setHeight(round((float)$xmlInfoProducts->product->height, 2));
                $productoGuardado->setWidth(round((float)$xmlInfoProducts->product->width, 2));
                $productoGuardado->setLength(round((float)$xmlInfoProducts->product->length, 2));

                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $eManager->persist($productoGuardado);
                $eManager->flush();
                $prodDefaultImage = $xmlInfoProducts->product->id_default_image->attributes('xlink', true)->href;
                $arrayDefImage = explode("//", $prodDefaultImage);
                $prodDefaultImage = $arrayDefImage[1];

                // Guardar la imagen por defecto
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $claveAPI."@".$prodDefaultImage);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $imagen = curl_exec($ch);
                curl_close($ch);
                $archivo = @fopen("Images/".$idEmpresa."_".$idProduct."_default.jpg", 'w');
                @fwrite($archivo, $imagen);
                @fclose($archivo);
            }
        }
        //Guardar datos en la base de datos
        foreach ($products as $infoProduct)
        {
            $entityManager = $this->getDoctrine()->getManager();
            $producto = new Products();
            $producto->setName($infoProduct['name']);
            $producto->setDescription($infoProduct['description']);
            $producto->setShortDescription($infoProduct['short_description']);
            $producto->setSupplierReference($infoProduct['supplier_reference']);
            $producto->setSupplierId($infoProduct['supplier_id']);
            $producto->setDateUpdate($infoProduct['date_update']);
            //$producto->setCategories($infoProduct['categories']);
            $producto->setPrice(round($infoProduct['price'], 2));
            $producto->setIva(round($product['iva'], 2));
            $producto->setHeight(round($infoProduct['height'], 2));
            $producto->setWidth(round($infoProduct['width'], 2));
            $producto->setLength(round($infoProduct['length'], 2));

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($producto);
            
            //Categorías
            foreach ($infoProduct['categories'] as $categoryName)
            {
                $em = $this->getDoctrine()->getManager();
                $repository = $this->getDoctrine()->getRepository(Categories::class);
                //Buscar categoría por el nombre en la base de datos
                $categoria = $repository->findOneBy(['name' => $categoryName]);
                if(!$categoria)
                {
                    //Si no existe la creamos
                    $categoria = new Categories();
                    $categoria->setName($categoryName);
                    $em->persist($categoria);
                    $em->flush();
                }
                //Guardar relación producto-categoria
                $producto->addCategories($categoria);
            }

            // Generar consulta insert de Product
            $entityManager->flush();
        }*/

        return new Response(
            '<html><body>Ids recogidos correctamente</body></html>'
        );
    }
}