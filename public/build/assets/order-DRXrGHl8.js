let s=window.Echo.channel("order-channel");s.listen(".order-status-update",e=>{console.log("Order status updated:",e.message),loadOrders(),showSuccessMessage("Order status updated")});
