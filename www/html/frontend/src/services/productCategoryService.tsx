import { ERROR_CREATING_PRODUCT_CATEGORY, ERROR_DELETING_CATEGORY, ERROR_EDITING_PRODUCT_CATEGORY, ERROR_GETTING_CATEGORIES } from "src/utils/messages";

const apiBaseUrl = process.env.NEXT_PUBLIC_API_BASE_URL;

export const getProductCategories = async () => {
  try {
    const response = await fetch(`${apiBaseUrl}/product/categories`);
    const data = await response.json();

    return data.data;
  } catch (error) {
    throw error;
  }
};

export const createProductCategory = async (requestData) => {
  try {
    const response = await fetch(`${apiBaseUrl}/product/categories`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(requestData),
    });

    if (!response.ok) {
      const data = await response.json();
      throw new Error(`${ERROR_CREATING_PRODUCT_CATEGORY}: ${data.message}`);
    }

    const data = await response.json();

    return data;
  } catch (error) {
    console.error(ERROR_CREATING_PRODUCT_CATEGORY, error);
    throw error;
  }
};

export const deleteProductCategory = async (categoryId) => {
  try {
    const response = await fetch(`${apiBaseUrl}/product/categories/${categoryId}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({}),
    });

    if (!response.ok) {
      throw new Error(`${ERROR_DELETING_CATEGORY}: ${response.statusText}`);
    }

    const data = await response.json();

    return data;
  } catch (error) {
    throw error;
  }
};

export const getProductCategoryDetails = async (categoryId) => {
  try {
    const response = await fetch(`${apiBaseUrl}/product/categories/${categoryId}`);
    const data = await response.json();

    return data.data;
  } catch (error) {
    console.error(ERROR_GETTING_CATEGORIES, error);
    throw error;
  }
};

export const updateProductCategory = async (categoryId, requestData) => {
  try {
    const response = await fetch(`${apiBaseUrl}/product/categories/${categoryId}`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(requestData),
    });

    if (!response.ok) {
      const data = await response.json();
      throw new Error(`${ERROR_EDITING_PRODUCT_CATEGORY}: ${data.message}`);
    }

    const data = await response.json();

    return data;
  } catch (error) {
    console.error(ERROR_EDITING_PRODUCT_CATEGORY, error);
    throw error;
  }
};
