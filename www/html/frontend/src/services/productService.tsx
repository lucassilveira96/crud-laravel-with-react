import { ERROR_CREATING_PRODUCT_CATEGORY, ERROR_DELETING_PRODUCT, ERROR_EDITING_PRODUCT, ERROR_FETCHING_PRODUCTS, ERROR_FETCHING_PRODUCT_DETAILS } from "src/utils/messages";

const apiBaseUrl = process.env.NEXT_PUBLIC_API_BASE_URL;

export const getProducts = async () => {
  try {
    const response = await fetch(`${apiBaseUrl}/products`);
    const data = await response.json();

    if (!response.ok) {
      throw new Error(`${ERROR_FETCHING_PRODUCTS} ${data.message}`);
    }

    return data.data;
  } catch (error) {
    throw error;
  }
};


export const getCategories = async () => {
  try {
    const response = await fetch(`${apiBaseUrl}/product/categories`);
    const data = await response.json();

    return data.data;
  } catch (error) {
    console.error(ERROR_FETCHING_PRODUCTS, error);
    throw error;
  }
};

export const deleteProduct = async (productId:any) => {
  try {
    const response = await fetch(`${apiBaseUrl}/products/${productId}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({}),
    });

    if (!response.ok) {
      const data = await response.json();
      throw new Error(`${ERROR_DELETING_PRODUCT} ${data.message}`);
    }

    return response.json();
  } catch (error) {
    throw error;
  }
};

export const createProduct = async (requestData:any) => {
  try {
    const response = await fetch(`${apiBaseUrl}/products`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(requestData),
    });

    if (!response.ok) {
      const data = await response.json();
      throw new Error(`${ERROR_CREATING_PRODUCT_CATEGORY} ${data.message}`);
    }

    const data = await response.json();

    return data;
  } catch (error) {
    console.error(ERROR_CREATING_PRODUCT_CATEGORY, error);
    throw error;
  }
};

export const getProductDetails = async (productId:any) => {
  try {
    const response = await fetch(`${apiBaseUrl}/products/${productId}`);
    const data = await response.json();

    if (!response.ok) {
      throw new Error(`${ERROR_FETCHING_PRODUCT_DETAILS}: ${data.message}`);
    }

    return data.data;
  } catch (error) {
    console.error(ERROR_FETCHING_PRODUCT_DETAILS, error);
    throw error;
  }
};

export const updateProduct = async (productId:any, requestData:any) => {
  try {
    const response = await fetch(`${apiBaseUrl}/products/${productId}`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(requestData),
    });

    if (!response.ok) {
      const data = await response.json();
      throw new Error(`${ERROR_EDITING_PRODUCT} ${data.message}`);
    }

    const data = await response.json();

    return data;
  } catch (error) {
    console.error(ERROR_EDITING_PRODUCT, error);
    throw error;
  }
};
