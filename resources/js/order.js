
let channel = window.Echo.channel('order-channel');
channel.listen('.order-status-update',  (event) => {
            console.log('Order status updated:', event.message);
            // Update the UI or handle the data accordingly
            loadOrders()
            showSuccessMessage('Order status updated')
           
        }
);
