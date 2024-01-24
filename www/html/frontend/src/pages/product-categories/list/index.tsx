import React, { useEffect, useState } from 'react';
import Button from '@mui/material/Button';
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogContentText from '@mui/material/DialogContentText';
import DialogTitle from '@mui/material/DialogTitle';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import TextField from '@mui/material/TextField';
import AddIcon from '@mui/icons-material/Add';
import Grid from '@mui/material/Grid';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import CircularProgress from '@mui/material/CircularProgress';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { useRouter } from 'next/router';
import {deleteProductCategory, getProductCategories } from '../../../services/productCategoryService';
import { CATEGORY_DELETED_SUCCESS, ERROR_CREATING_PRODUCT_CATEGORY, ERROR_DELETING_CATEGORY } from 'src/utils/messages';
import VisibilityIcon from '@mui/icons-material/Visibility';



const ConfirmDeleteDialog = ({ isOpen, onClose, onConfirmDelete }) => {
  return (
    <Dialog open={isOpen} onClose={onClose}>
      <DialogTitle>Confirmar Exclusão</DialogTitle>
      <DialogContent>
        <DialogContentText>
          Tem certeza de que deseja excluir esta categoria?
        </DialogContentText>
      </DialogContent>
      <DialogActions>
        <Button onClick={onClose}>Cancelar</Button>
        <Button onClick={onConfirmDelete} color="error">
          Excluir
        </Button>
      </DialogActions>
    </Dialog>
  );
};

const ProductCategoryList = () => {
  const [loading, setLoading] = useState(true);
  const [productCategories, setProductCategories] = useState([]);
  const [originalProductCategories, setOriginalProductCategories] = useState([]);
  const [deleteProductCategoryId, setDeleteProductCategoriesId] = useState(null);
  const [isDialogOpen, setIsDialogOpen] = useState(false);
  const [filter, setFilter] = useState('');
  const router = useRouter();
  const [viewCategoryId, setViewCategoryId] = useState(null);
  const [isViewDialogOpen, setIsViewDialogOpen] = useState(false);

  const handleViewCategory = (categoryId) => {
    setViewCategoryId(categoryId);
    setIsViewDialogOpen(true);
  };

  const handleCloseViewDialog = () => {
    setViewCategoryId(null);
    setIsViewDialogOpen(false);
  };

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const categories = await getProductCategories();
        setProductCategories(categories);
        setOriginalProductCategories(categories);
      } catch (error) {
        toast.error(ERROR_CREATING_PRODUCT_CATEGORY);
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, []);

  const handleDeleteProduct = async (productCategoryId) => {
    try {
      await deleteProductCategory(productCategoryId);
      setProductCategories((prevCategories) =>
        prevCategories.filter((productCategory) => productCategory.id !== productCategoryId)
      );
      setOriginalProductCategories((prevCategories) =>
        prevCategories.filter((productCategory) => productCategory.id !== productCategoryId)
      );
      toast.success(CATEGORY_DELETED_SUCCESS);
    } catch (error) {
      toast.error(ERROR_DELETING_CATEGORY);
    }
  };

  const handleOpenDialog = (productCategoryId) => {
    setDeleteProductCategoriesId(productCategoryId);
    setIsDialogOpen(true);
  };

  const handleCloseDialog = () => {
    setDeleteProductCategoriesId(null);
    setIsDialogOpen(false);
  };

  const handleConfirmDelete = () => {
    if (deleteProductCategoryId !== null) {
      handleDeleteProduct(deleteProductCategoryId);
      handleCloseDialog();
    }
  };

  const handleFilterChange = (event) => {
    const value = event.target.value.toLowerCase();
    setFilter(value);

    if (!value.length) {
      setProductCategories(originalProductCategories);
    } else {
      const filteredProductCategories = originalProductCategories.filter((product) =>
        product.product_category_name.toLowerCase().includes(value)
      );

      setProductCategories(filteredProductCategories);
    }
  };

  return (
    <Grid container spacing={6}>
      <Grid item xs={6}>
        {loading ? (
          null
        ) : (
          <TextField
            label="Filtrar por Nome"
            variant="outlined"
            value={filter}
            onChange={handleFilterChange}
            style={{ width: '60%' }}
          />
        )}
      </Grid>
      <Grid item xs={6} style={{ textAlign: 'right' }}>
        {loading ? (
          null
        ) : (
          <Button
            variant="contained"
            color="primary"
            startIcon={<AddIcon />}
            onClick={() => router.push(`/product-categories/add`)}
            style={{ width: '30%' }}
          >
            Adicionar
          </Button>
        )}
      </Grid>
      <Grid item xs={12}>
        {loading ? (
          <div style={{ textAlign: 'center', padding: '20px' }}>
            <CircularProgress />
          </div>
        ) : (
          <TableContainer component={Paper}>
            <Table>
              <TableHead>
                <TableRow>
                  <TableCell>ID</TableCell>
                  <TableCell>Nome</TableCell>
                  <TableCell>Ações</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {productCategories.length === 0 ? (
                  <TableRow>
                    <TableCell colSpan={4} align="center">
                      Nenhum produto cadastrado.
                    </TableCell>
                  </TableRow>
                ) : (
                  productCategories.map((productCategory) => (
                    <TableRow key={productCategory.id}>
                      <TableCell>{productCategory.id}</TableCell>
                      <TableCell>{productCategory.product_category_name}</TableCell>
                      <TableCell >
                        <Button
                          variant="outlined"
                          color="primary"
                          onClick={() => router.push(`/product-categories/edit/?id=${productCategory.id}`)}
                          startIcon={<EditIcon />}
                        >
                          Editar
                        </Button>
                        <Button
                          variant="outlined"
                          color="secondary"
                          startIcon={<VisibilityIcon />}
                          onClick={() => handleViewCategory(productCategory.id)}
                        >
                          Visualizar
                        </Button>
                        <Button
                          variant="outlined"
                          color="error"
                          startIcon={<DeleteIcon />}
                          onClick={() => handleOpenDialog(productCategory.id)}
                        >
                          Deletar
                        </Button>
                      </TableCell>
                    </TableRow>
                  ))
                )}
              </TableBody>
            </Table>
          </TableContainer>
        )}

        <ConfirmDeleteDialog
          isOpen={isDialogOpen}
          onClose={handleCloseDialog}
          onConfirmDelete={handleConfirmDelete}
        />
      </Grid>
      <Dialog open={isViewDialogOpen} onClose={() => handleCloseViewDialog()}>
          <DialogTitle>Detalhes da Categoria de Produto</DialogTitle>
          <DialogContent>
            {viewCategoryId !== null && (
              <div>
                <strong>ID:</strong> {productCategories.find((category) => category.id === viewCategoryId).id}<br />
                <strong>Nome:</strong> {productCategories.find((category) => category.id === viewCategoryId).product_category_name}<br />
              </div>
            )}
          </DialogContent>
          <DialogActions>
            <Button onClick={() => handleCloseViewDialog()}>Fechar</Button>
          </DialogActions>
      </Dialog>
      <ToastContainer />
    </Grid>
  );
};

export default ProductCategoryList;
