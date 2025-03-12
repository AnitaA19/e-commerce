const axios = require('axios');

exports.handler = async function(event, context) {
  try {
    if (event.httpMethod !== 'POST') {
      return {
        statusCode: 405,
        body: JSON.stringify({ error: 'Method Not Allowed' })
      };
    }

    console.log('Запрос получен:', event.body);

    const response = await axios({
      method: 'post',
      url: 'http://backend-ecommerce.atwebpages.com/index.php',
      headers: {
        'Content-Type': 'application/json',
      },
      data: JSON.parse(event.body),
    });

    console.log('Response status:', response.status);

    return {
      statusCode: 200,
      body: JSON.stringify(response.data)
    };
  } catch (error) {
    console.log('Error:', error.message);
    console.log('Details:', error.response?.data);
    
    return {
      statusCode: error.response?.status || 500,
      body: JSON.stringify({ 
        error: error.message,
        details: error.response?.data || 'Do not have details'
      })
    };
  }
};