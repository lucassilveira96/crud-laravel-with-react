import React, { ChangeEvent, FormEvent, useState } from 'react';
import Card from '@mui/material/Card';
import Grid from '@mui/material/Grid';
import CardHeader from '@mui/material/CardHeader';
import CardContent from '@mui/material/CardContent';
import TextField from '@mui/material/TextField';
import Button from '@mui/material/Button';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { useRouter } from 'next/router';
import { createProductCategory } from '../../../services/productCategoryService';
import { ERROR_CREATING_PRODUCT_CATEGORY, PRODUCT_CATEGORY_CREATED_SUCCESS, REQUIRED_FIELD } from 'src/utils/messages';

const ProductCategoryAdd = () => {
  const [formData, setFormData] = useState({
    productCategoryName: '',
  });

  const router = useRouter();
  const [formErrors, setFormErrors] = useState({
    productCategoryName: '',
  });

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

    if (Object.keys(errors).length > 0) {
      setFormErrors({
        productCategoryName: REQUIRED_FIELD}
        );

      return;
    }

    const requestData = {
      product_category_name: formData.productCategoryName,
    };

    try {
      await createProductCategory(requestData);
      toast.success(PRODUCT_CATEGORY_CREATED_SUCCESS);
      router.push(`/product-categories/list`);
    } catch (error) {
        toast.error(ERROR_CREATING_PRODUCT_CATEGORY);
    }

    setFormData({
      productCategoryName: '',
    });

    setFormErrors({
      productCategoryName: '',
    });
  };

  return (
    <Grid container spacing={6}>
      <Grid item xs={12}>
        <Card>
          <CardHeader title='Categoria de Produto' />
          <CardContent>
            <form onSubmit={handleSubmit}>
              <TextField
                label='Nome'
                name='productCategoryName'
                value={formData.productCategoryName}
                onChange={handleInputChange}
                fullWidth
                margin='normal'
                required
                error={Boolean(formErrors.productCategoryName)}
                helperText={formErrors.productCategoryName}
              />
              <Button type='submit' variant='contained' color='primary'>
                Cadastrar
              </Button>
            </form>
          </CardContent>
        </Card>
      </Grid>
      <ToastContainer />
    </Grid>
  );
};

export default ProductCategoryAdd;
