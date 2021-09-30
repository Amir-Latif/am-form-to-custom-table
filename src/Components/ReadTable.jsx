import React from "react";
import { Form, Table, Button } from 'react-bootstrap';

const ajaxUrl = passedObject.ajaxUrl;
const tableRecords = passedObject.tableRecords;
const tableColumns = passedObject.tableColumns;

const changeStatus = async (e) => {
    e.preventDefault();

    let data = new URLSearchParams();
    data.append('action', 'amftutReadTable');

    // Send the IDs of the checked rows in the table
    const formValues = document.querySelector('form');

    for (let i = 0; i < formValues.length - 1; i += 2) {
        if (formValues[i].checked) {
            data.append('key', formValues[i].name);
            data.append('label', formValues[i + 1].value);
        };
    }

    await fetch(ajaxUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Cache-Control': 'no-cache',
        },
        referrerPolicy: 'strict-origin-when-cross-origin',
        body: data
    })
        .then(window.location.reload())
}

const capitalize = (phrase) => {
    const arr = phrase.split('_');
    const newArr = arr.map(element => element[0].toUpperCase() + element.slice(1));
    return newArr.join(' ');
}


function ReadTable() {
    const [requiredInput, updateRequried] = React.useState([]);

    return (
        <React.Fragment>
            <div className="wrap">
                <div id="data-retrieval" className="table-responsive">
                    <Form onSubmit={e => changeStatus(e)}>
                        <h1>The Data Obtained From The Customer</h1>
                        {tableRecords.length === 0 ?
                            <h3>No data available in the table</h3>
                            :
                            <>
                                <Table striped hover bordered className="border border-primary align-middle">
                                    <thead className="align-middle table-dark">
                                        <tr>
                                            <th>Check for posting</th>
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
                                                <td>
                                                    <input type="checkbox" name={record.id} id={record.id}
                                                        onChange={e => e.target.checked ? updateRequried([...requiredInput, record.id]) : updateRequried([...requiredInput.filter(e => e !== record.id)])} />
                                                </td>
                                                <td><input type="text" name={record.id + "-label"} id={record.id + "-label"} required={[...requiredInput].includes(record.id)} /></td>

                                                {tableColumns.map((column, columnIndex) => (
                                                    column.COLUMN_NAME !== 'label' && (
                                                        column.COLUMN_NAME === 'id' ?
                                                            <th key={columnIndex}>{record[column.COLUMN_NAME]}</th>
                                                            :
                                                            <td key={columnIndex}>{record[column.COLUMN_NAME]}</td>

                                                    )))}
                                            </tr>
                                        ))}
                                    </tbody>
                                </Table>
                                <Button type="submit" className="btn btn-primary mt-4">Post Selections</Button>
                            </>
                        }
                    </Form>
                </div>
            </div>
        </React.Fragment >
    )
}

export default ReadTable;