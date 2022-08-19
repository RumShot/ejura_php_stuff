<?php
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('error_log', 'LOG/prod_errors_'.date("Y-m-d H:i:s").'.log');

$savedattributes = json_decode(file_get_contents('Ecode_list.json'), true);
$curl = curl_init();

set_time_limit(999000);

$xml_prod = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Products></Products>');

if (file_exists('ELKO attributes.xml')){
  $xml_attr = simplexml_load_file('ELKO attributes.xml');
}else{
  $xml_attr = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Attributes></Attributes>');
  $attrmainnode = $xml_attr->addChild("Atribute");
  $attrmainnode->addChild('elkoCode', '');
  $attrmainnode->addChild('Consumable_Colour', '');
  $attrmainnode->addChild('Consumable_Type', '');
  $attrmainnode->addChild('Description', '');
  $attrmainnode->addChild('Shipping_box_quantity', '');
  $attrmainnode->addChild('Unit_Brutto_Volume', '');
  $attrmainnode->addChild('Unit_Gross_Weight', '');
  $attrmainnode->addChild('Unit_Net_Weight', '');
  $attrmainnode->addChild('Vendor_Homepage', '');
  $attrmainnode->addChild('imgurl_0', '');
  $attrmainnode->addChild('imgurl_1', '');
  $attrmainnode->addChild('imgurl_2', '');
  $attrmainnode->addChild('imgurl_3', '');
  $attrmainnode->addChild('imgurl_4', '');
  $attrmainnode->addChild('imgurl_5', '');
  $attrmainnode->addChild('imgurl_6', '');
  $attrmainnode->addChild('imgurl_7', '');
  $attrmainnode->addChild('imgurl_8', '');
  $attrmainnode->addChild('imgurl_9', '');
  $attrmainnode->addChild('imgurl_10', '');
  $attrmainnode->addChild('imgurl_11', '');
  $attrmainnode->addChild('imgurl_12', '');
  $attrmainnode->addChild('imgurl_13', '');
  $attrmainnode->addChild('Dimensions', '');
  $attrmainnode->addChild('Full_Description_Line', '');
  $attrmainnode->addChild('IEEE_eightzerotwooneonea', '');
  $attrmainnode->addChild('IEEE_eightzerotwooneonen', '');
  $attrmainnode->addChild('Network_Device_Type', '');
  $attrmainnode->addChild('Shipping_Box_Depth', '');
  $attrmainnode->addChild('Shipping_Box_Height', '');
  $attrmainnode->addChild('Shipping_Box_Weight', '');
  $attrmainnode->addChild('Shipping_Box_Width', '');
  $attrmainnode->addChild('Colour', '');
  $attrmainnode->addChild('Model_number', '');
  $attrmainnode->addChild('Screen_size', '');
  $attrmainnode->addChild('Category_Code', '');
  $attrmainnode->addChild('Mtwo', '');
  $attrmainnode->addChild('NUC_series', '');
  $attrmainnode->addChild('Product_model_code', '');
  $attrmainnode->addChild('Option_for_Models', '');
  $attrmainnode->addChild('Product_Type', '');
  $attrmainnode->addChild('Drone_accessory_type', '');
  $attrmainnode->addChild('Model_name', '');
  $attrmainnode->addChild('onezerozero_mm_x_onezerozero_mm', '');
  $attrmainnode->addChild('sevenfive_mm_x_sevenfive_mm', '');
  $attrmainnode->addChild('Fits_screens_sized', '');
  $attrmainnode->addChild('Max_weight', '');
  $attrmainnode->addChild('Pallet_quantity', '');
  $attrmainnode->addChild('Number_of_screens', '');
  $attrmainnode->addChild('Buffer_memory_size', '');
  $attrmainnode->addChild('Drive_thickness', '');
  $attrmainnode->addChild('Form_Factor', '');
  $attrmainnode->addChild('HDD_Capacity', '');
  $attrmainnode->addChild('Rotation_speed', '');
  $attrmainnode->addChild('SATA', '');
  $attrmainnode->addChild('Battery', '');
  $attrmainnode->addChild('Battery_run_time_up_to', '');
  $attrmainnode->addChild('Flashlight_series', '');
  $attrmainnode->addChild('Illumination_application', '');
  $attrmainnode->addChild('IP_Rating', '');
  $attrmainnode->addChild('LED', '');
  $attrmainnode->addChild('Light_output', '');
  $attrmainnode->addChild('Max_Beam_distance', '');
  $attrmainnode->addChild('HDD_Family_name', '');
  $attrmainnode->addChild('USB_threezero', '');
  $attrmainnode->addChild('Battery_capacity', '');
  $attrmainnode->addChild('Read_speed', '');
  $attrmainnode->addChild('SATA_threezero', '');
  $attrmainnode->addChild('SSD_Capacity', '');
  $attrmainnode->addChild('onezeroonezerozeroonezerozerozeroM', '');
  $attrmainnode->addChild('Antenna_Gain', '');
  $attrmainnode->addChild('CPU', '');
  $attrmainnode->addChild('IEEE_eightzerotwooneoneac', '');
  $attrmainnode->addChild('RAM', '');
  $attrmainnode->addChild('Wireless_Frequency_Range', '');
  $attrmainnode->addChild('Cutting_width', '');
  $attrmainnode->addChild('Engine_speed', '');
  $attrmainnode->addChild('Engine_type', '');
  $attrmainnode->addChild('Power_consumption', '');
  $attrmainnode->addChild('Power_type', '');
  $attrmainnode->addChild('Voltage', '');
  $attrmainnode->addChild('Compatible_with', '');
  $attrmainnode->addChild('Display_technology', '');
  $attrmainnode->addChild('GPS__geotagging', '');
  $attrmainnode->addChild('Material', '');
  $attrmainnode->addChild('Operating_System', '');
  $attrmainnode->addChild('Screen_resolution', '');
  $attrmainnode->addChild('Wireless_connections', '');
  $attrmainnode->addChild('Mouse_Pad_features', '');
  $attrmainnode->addChild('CL', '');
  $attrmainnode->addChild('Frequency_speed', '');
  $attrmainnode->addChild('Memory_module_capacity', '');
  $attrmainnode->addChild('Memory_type', '');
  $attrmainnode->addChild('Memory_features', '');
  $attrmainnode->addChild('Module_form_factor', '');
  $attrmainnode->addChild('Nominal_voltage', '');
  $attrmainnode->addChild('Number_of_modules', '');
  $attrmainnode->addChild('Total_capacity', '');
  $attrmainnode->addChild('Chip_Organization', '');
  $attrmainnode->addChild('MTBF', '');
  $attrmainnode->addChild('NAND_flash_technology', '');
  $attrmainnode->addChild('SSD_series', '');
  $attrmainnode->addChild('TBW', '');
  $attrmainnode->addChild('Write_speed', '');
  $attrmainnode->addChild('Cache', '');
  $attrmainnode->addChild('Clock_speed', '');
  $attrmainnode->addChild('Core_name', '');
  $attrmainnode->addChild('CPU_Family_name', '');
  $attrmainnode->addChild('GPU_clock', '');
  $attrmainnode->addChild('GPU_Model', '');
  $attrmainnode->addChild('Number_of_cores', '');
  $attrmainnode->addChild('Packing_type', '');
  $attrmainnode->addChild('Socket', '');
  $attrmainnode->addChild('Wattage', '');
  $attrmainnode->addChild('Detector_Type', '');
  $attrmainnode->addChild('Included_Accessories', '');
  $attrmainnode->addChild('Power_supply_requirements', '');
  $attrmainnode->addChild('Fixing_kind', '');
  $attrmainnode->addChild('Frequency_response', '');
  $attrmainnode->addChild('Headset_features', '');
  $attrmainnode->addChild('Infrared', '');
  $attrmainnode->addChild('USB_type_C', '');
  $attrmainnode->addChild('NVMe', '');
  $attrmainnode->addChild('PCIE', '');
  $attrmainnode->addChild('Depth', '');
  $attrmainnode->addChild('Height', '');
  $attrmainnode->addChild('Width', '');
  $attrmainnode->addChild('Bluetooth', '');
  $attrmainnode->addChild('Impedance', '');
  $attrmainnode->addChild('fourpole_threefivemm', '');
  $attrmainnode->addChild('Sensitivity', '');
  $attrmainnode->addChild('Volume_control', '');
  $attrmainnode->addChild('fourzerozero_mm_x_fourzerozero_mm', '');
  $attrmainnode->addChild('Microphone_jack_threefivemm', '');
  $attrmainnode->addChild('Stereo_jack_threefivemm', '');
  $attrmainnode->addChild('Cord_length', '');
  $attrmainnode->addChild('Fits_Models', '');
  $attrmainnode->addChild('Charging_port', '');
  $attrmainnode->addChild('Special_modes', '');
  $attrmainnode->addChild('Memory_series', '');
  $attrmainnode->addChild('Memory_timings', '');
  $attrmainnode->addChild('Performance', '');
  $attrmainnode->addChild('Specific_features', '');
  $attrmainnode->addChild('Gaming_platform', '');
  $attrmainnode->addChild('USB_twozero', '');
  $attrmainnode->addChild('Flash_memory_capacity', '');
  $attrmainnode->addChild('Memory_Card_Type', '');
  $attrmainnode->addChild('Speed_Class', '');
  $attrmainnode->addChild('Included_adaptersreaders', '');
  $attrmainnode->addChild('Flash_drive_series', '');
  $attrmainnode->addChild('Lightning', '');
  $attrmainnode->addChild('Desktoppedestal', '');
  $attrmainnode->addChild('Output_power_capacity_VA', '');
  $attrmainnode->addChild('Output_power_capacity_W', '');
  $attrmainnode->addChild('RJoneone', '');
  $attrmainnode->addChild('Topology', '');
  $attrmainnode->addChild('USB', '');
  $attrmainnode->addChild('Wave_form_type', '');
  $attrmainnode->addChild('Operating_temperature_range', '');
  $attrmainnode->addChild('Flow_rate', '');
  $attrmainnode->addChild('Immersible', '');
  $attrmainnode->addChild('Max_water_temperature', '');
  $attrmainnode->addChild('Maximum_suction_lift', '');
  $attrmainnode->addChild('Pressure', '');
  $attrmainnode->addChild('Rated_power', '');
  $attrmainnode->addChild('Native_resolution', '');
  $attrmainnode->addChild('Still_Image_Resolution', '');
  $attrmainnode->addChild('Linux', '');
  $attrmainnode->addChild('MacOS', '');
  $attrmainnode->addChild('Mouse_Type', '');
  $attrmainnode->addChild('Resolution', '');
  $attrmainnode->addChild('Scroll', '');
  $attrmainnode->addChild('Windows_onezero', '');
  $attrmainnode->addChild('Windows_seven', '');
  $attrmainnode->addChild('Windows_eight', '');
  $attrmainnode->addChild('Windows_Vista', '');
  $attrmainnode->addChild('Windows_XP', '');
  $attrmainnode->addChild('Number_of_buttons', '');
  $attrmainnode->addChild('Average_Seek', '');
  $attrmainnode->addChild('Bytes_per_Sector', '');
  $attrmainnode->addChild('Network_Camera_Type', '');
  $attrmainnode->addChild('RJfourfive', '');
  $attrmainnode->addChild('Terminal_block', '');
  $attrmainnode->addChild('AudioIn', '');
  $attrmainnode->addChild('AudioOut', '');
  $attrmainnode->addChild('Camera_design', '');
  $attrmainnode->addChild('Focal_Length', '');
  $attrmainnode->addChild('MicroSD_Card_Slot', '');
  $attrmainnode->addChild('MicroUSB', '');
  $attrmainnode->addChild('Electronic_Shutter_Speed', '');
  $attrmainnode->addChild('IR_Illumination', '');
  $attrmainnode->addChild('Optical_Zoom', '');
  $attrmainnode->addChild('Sensor_size', '');
  $attrmainnode->addChild('onefivepin_Dsub', '');
  $attrmainnode->addChild('twofive_SATA_Hotswap', '');
  $attrmainnode->addChild('Case_Type', '');
  $attrmainnode->addChild('Chipset', '');
  $attrmainnode->addChild('Cooling_and_Ventilation_System', '');
  $attrmainnode->addChild('CPUs', '');
  $attrmainnode->addChild('Maximum_number_of_CPUs', '');
  $attrmainnode->addChild('PCIExpress_threezero_onesixx', '');
  $attrmainnode->addChild('PSU_Output_Power', '');
  $attrmainnode->addChild('SAS', '');
  $attrmainnode->addChild('Brightness', '');
  $attrmainnode->addChild('Contrast', '');
  $attrmainnode->addChild('Displayable_colours', '');
  $attrmainnode->addChild('DVID', '');
  $attrmainnode->addChild('Dynamic_contrast_DCR', '');
  $attrmainnode->addChild('Finish', '');
  $attrmainnode->addChild('Monitor_features', '');
  $attrmainnode->addChild('Panel_type', '');
  $attrmainnode->addChild('Power_supply', '');
  $attrmainnode->addChild('Refresh_rate', '');
  $attrmainnode->addChild('Response_time', '');
  $attrmainnode->addChild('Screen_form_factor', '');
  $attrmainnode->addChild('Screen_LED_backlight', '');
  $attrmainnode->addChild('Speakers', '');
  $attrmainnode->addChild('Tilt', '');
  $attrmainnode->addChild('Viewing_angle_horizontal', '');
  $attrmainnode->addChild('Viewing_angle_vertical', '');
  $attrmainnode->addChild('COM_via_Header', '');
  $attrmainnode->addChild('Memory_slots', '');
  $attrmainnode->addChild('Environment', '');
  $attrmainnode->addChild('Min_Illumination', '');
  $attrmainnode->addChild('Pixel_Resolution', '');
  $attrmainnode->addChild('Power_options', '');
  $attrmainnode->addChild('Distance_to_wall', '');
  $attrmainnode->addChild('USB_threeone', '');
  $attrmainnode->addChild('twozerozero_mm_x_twozerozero_mm', '');
  $attrmainnode->addChild('sixzerozero_mm_x_fourzerozero_mm', '');
  $attrmainnode->addChild('DWPD', '');
  $attrmainnode->addChild('threefive_Internal', '');
  $attrmainnode->addChild('twofive_SASSATA_Hotswap', '');
  $attrmainnode->addChild('COM', '');
  $attrmainnode->addChild('Proprietary', '');
  $attrmainnode->addChild('Thunderbolt', '');
  $attrmainnode->addChild('MicroSIM_card_tray', '');
  $attrmainnode->addChild('Turbo_frequency', '');
  $attrmainnode->addChild('Scooter_product_type', '');
  $attrmainnode->addChild('PCIExpress_fourzero_onesixx', '');
  $attrmainnode->addChild('threefive_SASSATA_Hotswap', '');
  $attrmainnode->addChild('PCIExpress_threezero__eightx', '');
  $attrmainnode->addChild('threefive_SAS_Hotswap', '');
  $attrmainnode->addChild('HDD_configuration', '');
  $attrmainnode->addChild('MiniSAS_ext', '');
  $attrmainnode->addChild('MiniUSB', '');
  $attrmainnode->addChild('Rack_fiveU', '');
  $attrmainnode->addChild('SFP', '');
  $attrmainnode->addChild('Supported_drives', '');
  $attrmainnode->addChild('twofive_SAS_Hotswap', '');
  $attrmainnode->addChild('Rack_twoU', '');
  $attrmainnode->addChild('Rack_fourU', '');
  $attrmainnode->addChild('CPU_Model_Number', '');
  $attrmainnode->addChild('Installed_CPUs', '');
  $attrmainnode->addChild('Installed_PSUs', '');
  $attrmainnode->addChild('Maximum_number_of_PSUs', '');
  $attrmainnode->addChild('Memory', '');
  $attrmainnode->addChild('Memory_configuration', '');
  $attrmainnode->addChild('NIC', '');
  $attrmainnode->addChild('NIC_twond', '');
  $attrmainnode->addChild('PSU', '');
  $attrmainnode->addChild('RAID', '');
  $attrmainnode->addChild('Server_management', '');
  $attrmainnode->addChild('SSD_configuration', '');
  $attrmainnode->addChild('Filter_type', '');
  $attrmainnode->addChild('twofive_NVMESATASAS_Hotswap', '');
  $attrmainnode->addChild('Optional_Accessories', '');
  $attrmainnode->addChild('GPU_quantity', '');
  $attrmainnode->addChild('twofive_NVMESATA_Hotswap', '');
  $attrmainnode->addChild('twozerozero_mm_x_onezerozero_mm', '');
  $attrmainnode->addChild('Integrated_LAN', '');
  $attrmainnode->addChild('Integrated_video', '');
  $attrmainnode->addChild('Serial', '');
  $attrmainnode->addChild('USB_threetwo', '');
  $attrmainnode->addChild('NAS_features', '');
  $attrmainnode->addChild('Number_of_drivesbays', '');
  $attrmainnode->addChild('Rack', '');
  $attrmainnode->addChild('Architecture_SW', '');
  $attrmainnode->addChild('ItemName', '');
  $attrmainnode->addChild('Localization', '');
  $attrmainnode->addChild('Manufacturer_code', '');
  $attrmainnode->addChild('Media_Type', '');
  $attrmainnode->addChild('Number_of_CPU__cores_licensed', '');
  $attrmainnode->addChild('Platform', '');
  $attrmainnode->addChild('Software_formulation', '');
  $attrmainnode->addChild('Software_License_Type', '');
  $attrmainnode->addChild('SW_Product_Family', '');
  $attrmainnode->addChild('Versions_year', '');
  $attrmainnode->addChild('License_type', '');
  $attrmainnode->addChild('KB_language', '');
  $attrmainnode->addChild('Keyboard_backlight', '');
  $attrmainnode->addChild('Keyboard_features', '');
  $attrmainnode->addChild('Radio_Frequence', '');
  $attrmainnode->addChild('Charging_time', '');
  $attrmainnode->addChild('Noise_level_max', '');
  $attrmainnode->addChild('Cutting_Height', '');
  $attrmainnode->addChild('Lawn_mower_type', '');
  $attrmainnode->addChild('Electrode_diameter', '');
  $attrmainnode->addChild('ISL_at_max', '');
  $attrmainnode->addChild('Max_current', '');
  $attrmainnode->addChild('Power_tool_type', '');
  $attrmainnode->addChild('Welding_current', '');
  $attrmainnode->addChild('Welding_features', '');
  $attrmainnode->addChild('Welding_process', '');
  $attrmainnode->addChild('Builtin_Network', '');
  $attrmainnode->addChild('Copy_function', '');
  $attrmainnode->addChild('Duty_Cycle_Maximum', '');
  $attrmainnode->addChild('Fax_Function', '');
  $attrmainnode->addChild('First_print', '');
  $attrmainnode->addChild('Fullduplex', '');
  $attrmainnode->addChild('Memory_RAM', '');
  $attrmainnode->addChild('Paper_format_and_sizemm', '');
  $attrmainnode->addChild('Paper_Handling_input', '');
  $attrmainnode->addChild('Paper_Handling_output', '');
  $attrmainnode->addChild('Print_speed_PPM', '');
  $attrmainnode->addChild('Printer_Technology', '');
  $attrmainnode->addChild('Resolution_up_to', '');
  $attrmainnode->addChild('Scan_function', '');
  $attrmainnode->addChild('WiFi', '');
  $attrmainnode->addChild('Retail_box_quantity', '');
  $attrmainnode->addChild('Length', '');
  $attrmainnode->addChild('Windows_twozerozerozero', '');
  $attrmainnode->addChild('Durability', '');
  $attrmainnode->addChild('Mouse_included', '');
  $attrmainnode->addChild('Number_of_Hot_Keys', '');
  $attrmainnode->addChild('Wireless_range', '');
  $attrmainnode->addChild('Data_transfer_rate', '');
  $attrmainnode->addChild('Number_of_ports', '');
  $attrmainnode->addChild('Port_Type', '');
  $attrmainnode->addChild('System_cache', '');
  $attrmainnode->addChild('Additional_model_name', '');
  $attrmainnode->addChild('sixzerozero_mm_x_fourfivezero_mm', '');
  $attrmainnode->addChild('eightzerozero_mm_x_fourfivezero_mm', '');
  $attrmainnode->addChild('HDMI_Micro_D', '');
  $attrmainnode->addChild('Wireless_LAN', '');
  $attrmainnode->addChild('threefive_SATA_Hotswap', '');
  $attrmainnode->addChild('DisplayPort', '');
  $attrmainnode->addChild('MicroATX', '');
  $attrmainnode->addChild('Toner_life', '');
  $attrmainnode->addChild('Connectors', '');
  $attrmainnode->addChild('Data_transmission_speed', '');
  $attrmainnode->addChild('IEEE_eightzerotwooneoneb', '');
  $attrmainnode->addChild('IEEE_eightzerotwooneoneg', '');
  $attrmainnode->addChild('Number_of_antennas', '');
  $attrmainnode->addChild('WPA__WiFi_Protected_Access', '');
  $attrmainnode->addChild('WPAtwo__WiFi_Protected_Access', '');
  $attrmainnode->addChild('Air_flow', '');
}

$mainnode = $xml_prod->addChild("Product");
$mainnode->addAttribute('id', '');
$mainnode->addAttribute('elkoCode', '');
$mainnode->addAttribute('name', '');
$mainnode->addAttribute('manufacturerCode', '');
$mainnode->addAttribute('vendorName', '');
$mainnode->addAttribute('vendorcode', '');
$mainnode->addAttribute('catalog', '');
$mainnode->addAttribute('catalogName', '');
$mainnode->addAttribute('quantity', '');
$mainnode->addAttribute('price', '');
$mainnode->addAttribute('discountPrice', '');
$mainnode->addAttribute('imagePath', '');
$mainnode->addAttribute('thumbnailImagePath', '');
$mainnode->addAttribute('fullDsc', '');
$mainnode->addAttribute('currency', '');
$mainnode->addAttribute('httpDescription', '');
$mainnode->addAttribute('packagingQuantity', '');
$mainnode->addAttribute('warranty', '');
$mainnode->addAttribute('eanCode', '');
$mainnode->addAttribute('obligatoryKit', '');
$mainnode->addAttribute('reservedQuantity', '');
$mainnode->addAttribute('promDate', '');
$mainnode->addAttribute('promQuant', '');
$mainnode->addAttribute('quantityForPrice2', '');
$mainnode->addAttribute('price2', '');
$mainnode->addAttribute('lotNumber', '');
$mainnode->addAttribute('copyrightTax', '');
$mainnode->addAttribute('incomingQuantity', '');

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.elko.cloud/v3.0/api/Catalog/Products',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: ' . $barear . ''
  ),
));

$response = curl_exec($curl);

//$response = json_decode(file_get_contents('prod.json'), true);
$response = json_decode($response, true);

for ($y = 0; $y <= count($response)-1; $y++){
  $mainnode = $xml_prod->addChild("Product");
  $singleprod = $response[$y];
  $id = $singleprod['id'];
  $mainnode->addAttribute('id', $id);
  $elkocode = $singleprod['elkoCode'];
  $mainnode->addAttribute('elkoCode', $elkocode);
  echo $elkocode . "<br>";
  $name = $singleprod['name'];
  $mainnode->addAttribute('name', $name);
  $manucode = $singleprod['manufacturerCode'];
  $mainnode->addAttribute('manufacturerCode', $manucode);
  $vendorname = $singleprod['vendorName'];
  $mainnode->addAttribute('vendorName', $vendorname);
  $vendorcode = $singleprod['vendorCode'];
  $mainnode->addAttribute('vendorcode', $vendorcode);
  $catalog = $singleprod['catalog'];
  $mainnode->addAttribute('catalog', $catalog);
  $catalogname = $singleprod['catalogName'];
  $mainnode->addAttribute('catalogName', $catalogname);
  $quantity = $singleprod['quantity'];
  $quantity = str_replace( array("&lt;","&gt;","+","<", ">", "="," "), '', $quantity);
  $mainnode->addAttribute('quantity', $quantity);
  $price = $singleprod['price'];
  $mainnode->addAttribute('price', $price);
  $discountprice = $singleprod['discountPrice'];
  $mainnode->addAttribute('discountPrice', $discountprice);
  $imagepath = $singleprod['imagePath'];
  $mainnode->addAttribute('imagePath', $imagepath);
  $thumbnailimagepath = $singleprod['thumbnailImagePath'];
  $mainnode->addAttribute('thumbnailImagePath', $thumbnailimagepath);
  $fulldsc = $singleprod['fullDsc'];
  $fulldsc = str_replace( array("<br>","&gt;br&lt;","&gt;","&lt;"), '', $fulldsc);
  $mainnode->addAttribute('fullDsc', $fulldsc);
  $currency = $singleprod['currency'];
  $mainnode->addAttribute('currency', $currency);
  $httpdescription = $singleprod['httpDescription'];
  $mainnode->addAttribute('httpDescription', $httpdescription);
  $packaginguantity = $singleprod['packagingQuantity'];
  $packaginguantity = str_replace( array("&lt;","&gt;","+","<", ">", "="," "), '', $packaginguantity);
  $mainnode->addAttribute('packagingQuantity', $packaginguantity);
  $warranty = $singleprod['warranty'];
  $mainnode->addAttribute('warranty', $warranty);
  $eancode = $singleprod['eanCode'];
  $mainnode->addAttribute('eanCode', $eancode);
  $obligatorykit = $singleprod['obligatoryKit'];
  $mainnode->addAttribute('obligatoryKit', $obligatorykit);
  $reservedquantity = $singleprod['reservedQuantity'];
  $reservedquantity = str_replace( array("&lt;","&gt;","+","<", ">", "="," "), '', $reservedquantity);
  $mainnode->addAttribute('reservedQuantity', $reservedquantity);
  $promdate = $singleprod['promDate'];
  $mainnode->addAttribute('promDate', $promdate);
  $promquant = $singleprod['promQuant'];
  $mainnode->addAttribute('promQuant', $promquant);
  $quantityforprice2 = $singleprod['quantityForPrice2'];
  $quantityforprice2 = str_replace( array("\\","&lt;","&gt;","+","<", ">", "="," "), '', $quantityforprice2);
  $mainnode->addAttribute('quantityForPrice2', $quantityforprice2);
  $price2 = $singleprod['price2'];
  $mainnode->addAttribute('price2', $price2);
  $lotnumber = $singleprod['lotNumber'];
  $mainnode->addAttribute('lotNumber', $lotnumber);
  $copyrighttax = $singleprod['copyrightTax'];
  $mainnode->addAttribute('copyrightTax', $copyrighttax);
  $incomingquantity = $singleprod['incomingQuantity'];
  $incomingquantity = str_replace( array("&lt;","&gt;","+","<", ">", "="," "), '', $incomingquantity);
  $mainnode->addAttribute('incomingQuantity', $incomingquantity);

  //echo $id . " " . $elkocode . "<br>" . $name . "<br>";

  if (!in_array($elkocode, $savedattributes))  {
      usleep(50000);
      include('elko download atributes.php');

      $result = $xml_attr->asXML('ELKO attributes.xml');

      array_push($savedattributes, $elkocode);

      file_put_contents("Ecode_list.json", json_encode($savedattributes));
    }
}
$writexml = $xml_prod->asXML(ELKO_PATH .'ELKO products.xml');
curl_close($curl);
echo "COMPLETE";