import React from "react";
import { Table } from 'react-bootstrap';

const tableRecords = passedObject.tableRecords;
const tableColumns = passedObject.tableColumns;


const capitalize = (phrase) => {
    const arr = phrase.split('_');
    const newArr = arr.map(element => element[0].toUpperCase() + element.slice(1));
    return newArr.join(' ');
}


function ReadTable() {

    return (
        <React.Fragment>
            <div className="wrap">
                <div id="data-retrieval" className="table-responsive">
                    <h1>The Data Obtained From The Customer</h1>
                    {tableRecords.length === 0 ?
                        <h3>No data available in the table</h3>
                        :
                        <>
                            <Table striped hover bordered className="border border-primary align-middle">
                                <thead className="align-middle table-dark">
                                    <tr>
                                        {tableColumns.map((item, index) => (
                                            <th scope="col" key={index}>
                                                {capitalize(item.COLUMN_NAME)}
                                            </th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody>
                                    {tableRecords.map((record, recordIndex) => (
                                        <tr key={recordIndex}>
                                            {tableColumns.map((column, columnIndex) => (
                                                column.COLUMN_NAME === 'id' ?
                                                    <th key={columnIndex}>{record[column.COLUMN_NAME]}</th>
                                                    :
                                                    <td key={columnIndex}>{record[column.COLUMN_NAME]}</td>

                                            ))}
                                        </tr>
                                    ))}
                                </tbody>
                            </Table>
                        </>
                    }
                </div>
            </div>
        </React.Fragment >
    )
}

export default ReadTable;