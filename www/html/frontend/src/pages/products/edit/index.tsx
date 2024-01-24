import React, { ChangeEvent, FormEvent, useEffect, useState } from 'react';
import Card from '@mui/material/Card';
import Grid from '@mui/material/Grid';
import CardHeader from '@mui/material/CardHeader';
import CardContent from '@mui/material/CardContent';
import TextField from '@mui/material/TextField';
import Button from '@mui/material/Button';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { useRouter } from 'next/router';
import MenuItem from '@mui/material/MenuItem';
import { getCategories, getProductDetails, updateProduct } from '../../../services/productService';
import {
  ERROR_FETCHING_CATEGORIES,
  REQUIRED_FIELD,
  PRODUCT_EDITED_SUCCESS,
  ERROR_EDITING_PRODUCT,
} from '../../../utils/messages';

interface ProductCategory {
  id: number;
  product_category_name: string;
}

interface ProductFormData {
  category: ProductCategory | null;
  productName: string;
  productValue: string;
}

const ProductEdit: React.FC = () => {
  const [formData, setFormData] = useState<ProductFormData>({
    category: null,
    productName: '',
    productValue: '',
  });

  const router = useRouter();
  const [categories, setCategories] = useState<ProductCategory[]>([]);
  const [formErrors, setFormErrors] = useState({
    category: null,
    productName: '',
    productValue: '',
  });
  const { id } = router.query;

  useEffect(() => {
    const fetchData = async () => {
      try {
        const categoriesData = await getCategories();
        setCategories(categoriesData);

        if (id) {
          const productDetails = await getProductDetails(id);
          const selectedCategory = productDetails.product_category;
          setFormData({
            category: selectedCategory,
            productName: productDetails.product_name,
            productValue: productDetails.product_value.toString(),
          });
        }
      } catch (error) {
        console.error(ERROR_FETCHING_CATEGORIES, error);
        toast.error(ERROR_FETCHING_CATEGORIES);
      }
    };

    fetchData();
  }, [id]);

  const handleInputChange = (e: ChangeEvent<HTMLInputElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });

    setFormErrors({
      ...formErrors,
      [e.target.name]: '',
    });
  };

  const handleCategoryChange = (e: ChangeEvent<{ value: unknown }>) => {
    const selectedCategory = categories.find(category => category.product_category_name === e.target.value);

    setFormData({
      ...formData,
      category: selectedCategory || null,
    });

    setFormErrors({
      ...formErrors,
      category: null,
    });
  };

  const handleSubmit = async (e: FormEvent) => {
    e.preventDefault();

    const errors: { [key: string]: string } = {};
    if (formData && typeof formData === 'object') {
      Object.keys(formData).forEach((key) => {
        const formDataKey = key as keyof typeof formData;

        if (!formData[formDataKey]) {
          errors[key] = REQUIRED_FIELD;
        }
      });
    }

    const requestData = {
      product_category_id: formData.category?.id,
      product_name: formData.productName,
      product_value: parseFloat(formData.productValue),
    };

    try {
      await updateProduct(id, requestData);

      toast.success(PRODUCT_EDITED_SUCCESS);
      router.push(`/products/list`);
    } catch (error) {
      toast.error(ERROR_EDITING_PRODUCT);
    }
  };

  return (
    <Grid container spacing={6}>
      <Grid item xs={12}>
        <Card>
          <CardHeader title='Editar Produto' />
          <CardContent>
            <form onSubmit={handleSubmit}>
              <TextField
                label='Nome'
                name='productName'
                value={formData.productName}
                onChange={handleInputChange}
                fullWidth
                margin='normal'
                required
                error={Boolean(formErrors.productName)}
                helperText={formErrors.productName}
              />
              <TextField
                label='Categoria'
                name='category'
                value={formData.category ? formData.category.product_category_name : ''}
                onChange={handleCategoryChange}
                select
                fullWidth
                margin='normal'
                required
                error={Boolean(formErrors.category)}
                helperText={formErrors.category}
              >
                {categories.map((category) => (
                  <MenuItem key={category.id} value={category.product_category_name}>
                    {category.product_category_name}
                  </MenuItem>
                ))}
              </TextField>
              <TextField
                label='Valor'
                name='productValue'
                value={formData.productValue}
                onChange={handleInputChange}
                type='number'
                fullWidth
                margin='normal'
                required
                error={Boolean(formErrors.productValue)}
                helperText={formErrors.productValue}
              />
              <Button type='submit' variant='contained' color='primary'>
                Salvar
              </Button>
            </form>
          </CardContent>
        </Card>
      </Grid>
      <ToastContainer />
    </Grid>
  );
};

export default ProductEdit;
