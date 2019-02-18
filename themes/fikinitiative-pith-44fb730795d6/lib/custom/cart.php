<?php

/*
*   Customize cart table
*/

add_filter('cart_format', 'customize_cart');

function customize_cart($format){

    $format['before_cart'] = '<table class="table table-striped">';
    $format['after_cart'] = '</table>';
    $format['before_header_row'] = '<tr>';
    $format['after_header_row'] = '</tr>';
    $format['before_row'] = '<tr id="cart_item_%s" class="cart_item_row">';
    $format['after_row'] = '</tr>';
    $format['before_element'] = '<td>';
    $format['after_element'] = '</td>';
    $format['before_header'] = '<thead>';
    $format['after_header'] = '</thead>';
    $format['before_header_element'] = '<th>';
    $format['after_header_element'] = '</th>';
    $format['before_body'] = '<tbody>';
    $format['after_body'] = '</tbody>';
    $format['before_total'] = '<tfoot><tr class="fik-cart-subtotal-row">';
    $format['after_total'] = '</tr></tfoot>';
    $format['before_total_title'] = '<td colspan="4"><strong>';
    $format['after_total_title'] = '</strong></td>';
    $format['before_total_element'] = '<td><strong>';
    $format['after_total_element'] = '</strong></td>';
    $format['cart_image_element'] = '<td class="cart_image"><a href="%s"><img src="%s" alt="%s"></a></td>';
    $format['product_name_element'] = '<td><a href="%s">%s</a><br/>%s</td>';
    $format['quantity_form'] = '<td><form action="" method="post"><input type="hidden" name="cart_item_%s" value="%s" class="nueva_clase"><input type="number" name="cart_item_%s_quantity" min="0" max="10" step="1" value="%s" placeholder="%s" class="input-mini" required=""><button type="submit" class="cart_item_update btn btn-small btn-primary" name="update_quantity">%s</button></form></td>';
    $format['product_price'] = '<td>%s</td>';
    $format['product_subtotal'] = '<td>%s</td>';
    $format['checkout_form'] = '<form action="" class="fik_to_checkout text-center" method="post" enctype="multipart/form-data"><button name="checkout" type="submit" class="button alt btn btn-large btn-primary">%s</button></form>';

    return $format;
}
