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
import { deleteProduct, getProducts } from 'src/services/productService';
import { ERROR_DELETING_PRODUCT, ERROR_FETCHING_PRODUCTS, PRODUCT_DELETED_SUCCESS } from 'src/utils/messages';
import VisibilityIcon from '@mui/icons-material/Visibility';

const ProductList = () => {
  const [loading, setLoading] = useState(true);
  const [products, setProducts] = useState([]);
  const [originalProducts, setOriginalProducts] = useState([]);
  const [deleteProductId, setDeleteProductId] = useState(null);
  const [isDialogOpen, setIsDialogOpen] = useState(false);
  const [filter, setFilter] = useState('');
  const router = useRouter();
  const [viewProductId, setViewProductId] = useState(null);
  const [isViewDialogOpen, setIsViewDialogOpen] = useState(false);

  const handleViewProduct = (productId) => {
    setViewProductId(productId);
    setIsViewDialogOpen(true);
  };

  const handleCloseViewDialog = () => {
    setViewProductId(null);
    setIsViewDialogOpen(false);
  };

  const fetchProducts = async () => {
    try {
      setLoading(true);
      const productsData = await getProducts();
      setProducts(productsData);
      setOriginalProducts(productsData);
    } catch (error) {
      toast.error(ERROR_FETCHING_PRODUCTS);
    } finally {
      setLoading(false);
    }
  };

  const handleDeleteProduct = async (productId) => {
    try {
      await deleteProduct(productId);
      toast.success(PRODUCT_DELETED_SUCCESS);
      setProducts(products.filter((product) => product.id !== productId));
      setOriginalProducts(products.filter((product) => product.id !== productId));
    } catch (error) {
      toast.error(ERROR_DELETING_PRODUCT);
    }
  };

  const handleOpenDialog = (productId) => {
    setDeleteProductId(productId);
    setIsDialogOpen(true);
  };

  const handleCloseDialog = () => {
    setDeleteProductId(null);
    setIsDialogOpen(false);
  };

  const handleConfirmDelete = () => {
    if (deleteProductId !== null) {
      handleDeleteProduct(deleteProductId);
      handleCloseDialog();
    }
  };

  const handleFilterChange = (event) => {
    const value = event.target.value.toLowerCase();
    setFilter(value);

    if (!value.length) {
      setProducts(originalProducts);
    } else {
      const filteredProducts = originalProducts.filter((product) =>
        product.product_name.toLowerCase().includes(value)
      );

      setProducts(filteredProducts);
    }
  };

  useEffect(() => {
    fetchProducts();
  }, []);

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
            style={{ width: '60%'}}
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
            onClick={() => router.push(`/products/add`)}
            style={{ width: '30%'}}
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
              <TableCell>Categoria</TableCell>
              <TableCell>Valor</TableCell>
              <TableCell>Ações</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
          {
            products.length === 0 ? (
              <TableRow>
                <TableCell colSpan={4} align="center">
                  Nenhum produto cadastrado.
                </TableCell>
              </TableRow>
            ) : (
              products.map((product) => (
                <TableRow key={product.id}>
                  <TableCell>{product.id}</TableCell>
                  <TableCell>{product.product_name}</TableCell>
                  <TableCell>{product.product_category.product_category_name}</TableCell>
                  <TableCell>{product.product_value}</TableCell>
                  <TableCell>
                  <Button
                   variant="outlined"
                   color="primary"
                   onClick={() => router.push(`/products/edit/?id=${product.id}`)}
                   startIcon={<EditIcon />}
                >
                  Editar
                </Button>
                <Button
                    variant="outlined"
                    color="secondary"
                    startIcon={<VisibilityIcon />}
                    onClick={() => handleViewProduct(product.id)}
                  >
                    Visualizar
                </Button>
                <Button
                  variant="outlined"
                  color="error"
                  startIcon={<DeleteIcon />}
                  onClick={() => handleOpenDialog(product.id)}
                >
                  Deletar
                </Button>
                  </TableCell>
                </TableRow>
              ))
            )
          }
          </TableBody>
        </Table>
      </TableContainer>
      )}

      <Dialog open={isDialogOpen} onClose={() => handleCloseDialog()}>
        <DialogTitle>Confirmar Exclusão</DialogTitle>
        <DialogContent>
          <DialogContentText>
            Tem certeza de que deseja excluir este produto?
          </DialogContentText>
        </DialogContent>
        <DialogActions>
          <Button onClick={() => handleCloseDialog()}>Cancelar</Button>
          <Button onClick={() => handleConfirmDelete()} color="error">
            Excluir
          </Button>
        </DialogActions>
      </Dialog>
      <Dialog open={isViewDialogOpen} onClose={() => handleCloseViewDialog()}>
        <DialogTitle>Detalhes do Produto</DialogTitle>
        <DialogContent>
          {viewProductId !== null && (
            <div>
              <strong>ID:</strong> {products.find((product) => product.id === viewProductId).id}<br />
              <strong>Nome:</strong> {products.find((product) => product.id === viewProductId).product_name}<br />
              <strong>Categoria:</strong> {products.find((product) => product.id === viewProductId).product_category.product_category_name}<br />
              <strong>Valor:</strong> {products.find((product) => product.id === viewProductId).product_value}<br />
            </div>
          )}
        </DialogContent>
        <DialogActions>
          <Button onClick={() => handleCloseViewDialog()}>Fechar</Button>
        </DialogActions>
      </Dialog>
    </Grid>
    <ToastContainer />
    </Grid>
  );
};

export default ProductList;
