(function () {
    'use strict'; 
 
    var initParent = BX.Sale.OrderAjaxComponent.init,
        getBlockFooterParent = BX.Sale.OrderAjaxComponent.getBlockFooter,
        editOrderParent = BX.Sale.OrderAjaxComponent.editOrder,
        editDeliveryInfoParent = BX.Sale.OrderAjaxComponent.editDeliveryInfo,
        editFadeDeliveryContentParent = BX.Sale.OrderAjaxComponent.editFadeDeliveryContent
        ;
 
    BX.namespace('BX.Sale.OrderAjaxComponentExt');    
 
    BX.Sale.OrderAjaxComponentExt = BX.Sale.OrderAjaxComponent;
    
    
    var initOptionsParent = BX.Sale.OrderAjaxComponent.initOptions;
    
    BX.Sale.OrderAjaxComponentExt.initOptions = function() {
        initOptionsParent.apply(this, arguments);
        this.propertyDeliveryCollection = new BX.Sale.PropertyCollection(BX.merge({publicMode: true}, this.result.DELIVERY_PROPS));
    };
    
   
	BX.Sale.OrderAjaxComponentExt.editDeliveryInfo = function(deliveryNode) {
        editDeliveryInfoParent.apply(this, arguments); //вызываем родителя
        var deliveryInfoContainer = deliveryNode.querySelector('.bx-soa-pp-company-desc'); //находим блок с описанием службы доставки
        var group, property, groupIterator = this.propertyDeliveryCollection.getGroupIterator(), propsIterator, htmlAddress;
		
		//используем коллекцию, инициализированную в предыдущем методе
        var deliveryItemsContainer = BX.create('DIV', {props: {className: 'bx-soa-delivery'}}); //создаем контейнер для будущего поля
        while (group = groupIterator())
        {
            propsIterator =  group.getIterator();
            while (property = propsIterator())
            {
                if (property.getGroupId() == 7) { //если это свойство является параметром доставки
                    this.getPropertyRowNode(property, deliveryItemsContainer, false); //вставляем свойство в подготовленный контейнер
                    deliveryInfoContainer.appendChild(deliveryItemsContainer); //контейнер вместе со свойством в нём добавляем в конце блока с описанием (deliveryInfoContainer)

                }
            }
        }
    };
    
    
    


 
 
    BX.Sale.OrderAjaxComponentExt.initFirstSection = function (parameters) {
 
    };
 
 
})();