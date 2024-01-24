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
import { getProductCategoryDetails, updateProductCategory } from '../../../services/productCategoryService';
import { ERROR_EDITING_PRODUCT_CATEGORY, ERROR_LOADING_DATA, PRODUCT_CATEGORY_EDITED_SUCCESS, REQUIRED_FIELD } from 'src/utils/messages';

const ProductCategoryEdit = () => {
  const router = useRouter();
  const { id } = router.query;
  const [formData, setFormData] = useState({
    productCategoryName: '',
  });

  const [formErrors, setFormErrors] = useState({
    productCategoryName: '',
  });

  useEffect(() => {
    const fetchData = async () => {
      try {
        if (id) {
          const productCategoryDetails = await getProductCategoryDetails(id);
          setFormData({
            productCategoryName: productCategoryDetails.product_category_name,
          });
        }
      } catch (error) {
        console.error(ERROR_LOADING_DATA, error);
      }
    };

    fetchData();
  }, [id]);

  const handleInputChange = (e: ChangeEvent<HTMLInputElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
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
      //setFormErrors(REQUIRED_FIELD);

      return;
    }

    const requestData = {
      product_category_name: formData.productCategoryName,
    };

    try {
      await updateProductCategory(id, requestData);
      toast.success(PRODUCT_CATEGORY_EDITED_SUCCESS);
      router.push('/product-categories/list');
    } catch (error) {
        toast.error(ERROR_EDITING_PRODUCT_CATEGORY);
    }

    setFormErrors({
      productCategoryName: '',
    });
  };

  return (
    <Grid container spacing={6}>
      <Grid item xs={12}>
        <Card>
          <CardHeader title='Editar Categoria do Produto' />
          <CardContent>
            <form onSubmit={handleSubmit}>
              <TextField
                label='Nome'
                name='productCategoryName'
                value={formData.productCategoryName}
                fullWidth
                onChange={handleInputChange}
                margin='normal'
                required
                error={Boolean(formErrors.productCategoryName)}
                helperText={formErrors.productCategoryName}
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

export default ProductCategoryEdit;
