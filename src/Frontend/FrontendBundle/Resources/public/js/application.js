simpleCart({
    // array representing the format and columns of the cart,
    // see the cart columns documentation
    cartColumns: [
        {
            attr: "ids",
            label: 'IDS'
        },
        {
            attr: "name",
            label: "Produkt"
        },
        {
            attr: "size",
            label: "Wersja"
        }, {
            view: 'image',
            attr: 'thumb',
            label: false
        }, {
            view: "currency",
            attr: "price",
            label: "Cena"
        }, {
            view: "decrement",
            label: false,
            text: '<span class="glyphicon glyphicon-minus"></span>'
        }, {
            attr: "quantity",
            label: "Ilość"
        }, {
            view: "increment",
            label: false,
            text: '<span class="glyphicon glyphicon-plus"></span>'
        }, {
            view: "currency",
            attr: "total",
            label: "Razem"
        }, {
            view: "remove",
            text: '<span class="glyphicon glyphicon-remove"></span>',
            label: false
        }],
    // "div" or "table" - builds the cart as a 
    // table or collection of divs
    cartStyle: "table",
    // how simpleCart should checkout, see the 
    // checkout reference for more info 
    checkout: {
        type: "SendForm",
        url: orderUrl
    },
    // set the currency, see the currency 
    // reference for more info
    currency: "PLN",
    // collection of arbitrary data you may want to store 
    // with the cart, such as customer info
    data: {},
    // set the cart langauge 
    // (may be used for checkout)
    language: "english-us",
    // array of item fields that will not be 
    // sent to checkout
    excludeFromCheckout: [],
    // custom function to add shipping cost
    shippingCustom: function(){
        if(simpleCart.total() < 200){
            $select = $(document).find('input[name=shiping_type]:checked');
            return parseFloat($select.val());
        }else{
            return 0;
        }
    },
    // flat rate shipping option
    shippingFlatRate: 0,
    // added shipping based on this value 
    // multiplied by the cart quantity
    shippingQuantityRate: 0,
    // added shipping based on this value 
    // multiplied by the cart subtotal
    shippingTotalRate: 0,
    // tax rate applied to cart subtotal
    taxRate: 0,
    // true if tax should be applied to shipping
    taxShipping: false,
    // event callbacks 
    beforeAdd: null,
    afterAdd: null,
    load: null,
    beforeSave: null,
    afterSave: null,
    update: null,
    ready: null,
    checkoutSuccess: null,
    checkoutFail: null,
    beforeCheckout: null,
    beforeRemove: null
});
// basic callback example
simpleCart.bind('beforeAdd', function (item) {
    if (item.get('size') == 'ind') {
        item.price(config.individualPrice);
    } else if (item.get('size') == 'pro') {
        item.price(config.proffesionalPrice);     
    }
    item.set('ids',config.itemId);
    return item;
});
simpleCart.bind("afterAdd", function (item) {
    $(".koszyk").fadeOut(500).fadeIn(500);
    
});
simpleCart.bind('update', function () {
    var array = [];
    simpleCart.each(function (item) {
        array.push({"id":item.get('ids'), "quantity":item.get('quantity'), "type":item.get("size"), "price": item.get("price")});
    });
    document.cookie = "cart="+ JSON.stringify(array)+";path=/";
    if (simpleCart.quantity() == 0) {
        $(".hideIfEmpty").hide();
        $(".showIfEmpty").show();
    } else {
        $(".hideIfEmpty").show();
        $(".showIfEmpty").hide();
    }
});
$(function () {
    $select = $(document).find('input[name=shiping_type]');
    $select.on('click', function(){
        simpleCart.update();
    });
    $('#Container').mixItUp();
});