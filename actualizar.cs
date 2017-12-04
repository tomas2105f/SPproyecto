if (dgvProductos.Rows.Count > 0)
            {
                DialogResult dialogResult = MessageBox.Show("¿Deseas liberar esta salida?", "Sistema de Inventario", MessageBoxButtons.YesNo);
                if (dialogResult == DialogResult.Yes)
                {
                    //Variable para guardar consulta
                    string qry = "";
                    //variable para extraer la configuracion del app config
                    AppSetting setting = new AppSetting();
                    string cadenaconexion = setting.GetConnectionString("cadenaconexion");
                    //Variable para conectarnos a la BD
                    SqlConnection sqlCNX = new SqlConnection(cadenaconexion);
                    //Variable para guardar el objeto o comando
                    SqlCommand sqlCMD = new SqlCommand();
                    //Codigo para cachar errores
                    try
                    {
                        int id_Salida = int.Parse(this.txtIdSalida.Text);

                        foreach (DataGridViewRow row in dgvProductos.Rows)
                        {
                            int id_prod = int.Parse(row.Cells["idProducto"].Value.ToString());
                            int cant_prod = int.Parse(row.Cells["Cantidad"].Value.ToString());

                            //Guardamos la consulta en la variable 
                            qry = "INSERT INTO detalle_salida(id_salida, id_producto, precio_venta, cantidad, fecha_registro, hora_registro, activo, id_usuario) " +
                                "VALUES('" + id_Salida + "', '" + id_prod + "',  '" + row.Cells["Precio"].Value.ToString() + "', '" + cant_prod + "', '" + lblFecha.Text + "', '" + lblHora.Text + "', '" + txtActivo.Text + "', '" + frmPrincipal.idLogeado + "')";
                            //Asignamos las consulta al comando
                            sqlCMD.CommandText = qry;
                            //Asignamos la conexion al comando
                            sqlCMD.Connection = sqlCNX;
                            //Abrimos la conexion
                            sqlCNX.Open();
                            sqlCMD.ExecuteReader();
                            sqlCNX.Close();
                        }

                        //Guardamos la consulta en la variable 
                        qry = "UPDATE salidas SET total = " + txtGranTotal.Text + " WHERE id_salida = " + txtIdSalida.Text;
                        //Asignamos las consulta al comando
                        sqlCMD.CommandText = qry;
                        //Asignamos la conexion al comando
                        sqlCMD.Connection = sqlCNX;
                        //Abrimos la conexion
                        sqlCNX.Open();
                        sqlCMD.ExecuteReader();
                        sqlCNX.Close();

                        cargar();

                        MessageBox.Show("Se ha liberado la salida", "Información", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    }
                    catch (SqlException ex)
                    {
                        MessageBox.Show("Error al registrar nueva salida.\n" + ex.Message.ToString());
                    }

                }
                else if (dialogResult == DialogResult.No)
                {
                    return;
                }
            }
            else
            {
                MessageBox.Show("No hay productos en esta venta");
            }
