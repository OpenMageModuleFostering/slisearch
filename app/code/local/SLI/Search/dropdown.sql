SELECT `e`.`entity_id` 
       AS 
       `product_id`, 
       IF(at_name.value_id > 0, at_name.value, at_name_default.value) 
       AS `name`, 
       IF(at_url_path.value_id > 0, at_url_path.value, 
       at_url_path_default.value) AS 
       `url_path`, 
       IF(at_somethingspecial.value_id > 0, at_somethingspecial.value, 
       at_somethingspecial_default.value) 
       AS `somethingspecial`, 
       Group_concat(DISTINCT opt_somethingspecial.value SEPARATOR '|') 
       AS 
       `option_somethingspecial` 
FROM   `catalog_product_entity` AS `e` 
       INNER JOIN `catalog_product_entity_int` AS `at_status_default` 
               ON ( `at_status_default`.`entity_id` = `e`.`entity_id` ) 
                  AND ( `at_status_default`.`attribute_id` = '273' ) 
                  AND `at_status_default`.`store_id` = 0 
       LEFT JOIN `catalog_product_entity_int` AS `at_status` 
              ON ( `at_status`.`entity_id` = `e`.`entity_id` ) 
                 AND ( `at_status`.`attribute_id` = '273' ) 
                 AND ( `at_status`.`store_id` = 2 ) 
       INNER JOIN `catalog_product_website` AS `product_website` 
               ON product_website.product_id = e.entity_id 
                  AND product_website.website_id = '1' 
       LEFT JOIN `catalog_product_entity_varchar` AS `at_name_default` 
              ON ( `at_name_default`.`entity_id` = `e`.`entity_id` ) 
                 AND ( `at_name_default`.`attribute_id` = '96' ) 
                 AND `at_name_default`.`store_id` = 0 
       LEFT JOIN `catalog_product_entity_varchar` AS `at_name` 
              ON ( `at_name`.`entity_id` = `e`.`entity_id` ) 
                 AND ( `at_name`.`attribute_id` = '96' ) 
                 AND ( `at_name`.`store_id` = '2 OR `at_name`.`store_id` = 1' ) 
       LEFT JOIN `catalog_product_entity_varchar` AS `at_url_path_default` 
              ON ( `at_url_path_default`.`entity_id` = `e`.`entity_id` ) 
                 AND ( `at_url_path_default`.`attribute_id` = '570' ) 
                 AND `at_url_path_default`.`store_id` = 0 
       LEFT JOIN `catalog_product_entity_varchar` AS `at_url_path` 
              ON ( `at_url_path`.`entity_id` = `e`.`entity_id` ) 
                 AND ( `at_url_path`.`attribute_id` = '570' ) 
                 AND ( `at_url_path`.`store_id` = 
                       '2 OR `at_url_path`.`store_id` = 1' ) 
       LEFT JOIN `catalog_product_entity_int` AS `at_somethingspecial_default` 
              ON ( `at_somethingspecial_default`.`entity_id` = `e`.`entity_id` ) 
                 AND ( `at_somethingspecial_default`.`attribute_id` = '1004' ) 
                 AND `at_somethingspecial_default`.`store_id` = 0 
       LEFT JOIN `catalog_product_entity_int` AS `at_somethingspecial` 
              ON ( `at_somethingspecial`.`entity_id` = `e`.`entity_id` ) 
                 AND ( `at_somethingspecial`.`attribute_id` = '1004' ) 
                 AND ( `at_somethingspecial`.`store_id` = 
                       '1 OR `at_somethingspecial`.`store_id` = 1' 
                     ) 
       LEFT JOIN `eav_attribute_option_value` AS `opt_somethingspecial` 
              ON Concat(',', at_somethingspecial.value, ',') LIKE 
                 Concat('%,', opt_somethingspecial.option_id, ',%') 
WHERE  ( IF(at_status.value_id > 0, at_status.value, at_status_default.value) = 
         '1' ) 
GROUP  BY e.entity_id having e.entity_id = 168;
