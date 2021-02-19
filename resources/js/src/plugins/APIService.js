import axios from 'axios';
export const APIService = axios.create({
  baseURL: 'api/'
})
