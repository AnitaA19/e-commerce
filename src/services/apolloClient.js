import { ApolloClient, InMemoryCache, HttpLink } from '@apollo/client';
import { API_URL } from '../constants';

const client = new ApolloClient({
  link: new HttpLink({
    uri: API_URL, 
    headers: {
      'Content-Type': 'application/json',
    },
  }),
  cache: new InMemoryCache(),
});

export default client;
