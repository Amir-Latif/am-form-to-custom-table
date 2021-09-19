import React from "react";
import { Form, Button } from 'react-bootstrap';

const ajaxUrl = passedObject.ajaxUrl;

const postData = async (e) => {
    e.preventDefault();

    let data = new URLSearchParams();
    data.append('action', 'amftutCreateTable');

    const formValues = document.querySelector('form');
    for (let i = 0; i < formValues.length - 1; i += 3) {
        data.append(formValues[i].name, formValues[i].value);
        data.append(formValues[i + 1].id, formValues[i + 1].value);
        data.append(formValues[i + 2].id, formValues[i + 2].checked);
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
        .then(response => response.status === 200 && alert('Table created successfully'));
}


function CreateTable() {
    const [fieldsCount, updateCounter] = React.useState(1);

    return (
        <React.Fragment>
            <h1>Create Custom Database Table</h1>

            <Form onSubmit={e => postData(e)}>
                {[...Array(fieldsCount)].map((item, index) => (
                    <Form.Group key={index + 1} className="flex-form">
                        <Form.Label htmlFor={`field-${index + 1}-name`}>Field No.{index + 1}</Form.Label>
                        <Form.Control name={`field-${index + 1}-name`} type="text" id={`field-${index + 1}-name`} placeholder="Field Name" />

                        <Form.Label htmlFor={`field-${index + 1}-type`}>Type</Form.Label>
                        <Form.Control as="select" id={`field-${index + 1}-type`}>
                            <option selected>Short Text</option>
                            <option>Long Text</option>
                            <option>Email</option>
                            <option>Number</option>
                            <option>Checkbox</option>
                        </Form.Control>

                        <Form.Label htmlFor={`field-${index + 1}-required`}>Mandatory?</Form.Label>
                        <Form.Control type="checkbox" id={`field-${index + 1}-mandatory`} />
                    </Form.Group>
                ))}

                <Button type="submit" onSubmit={e => postData(e)}>Create Table</Button>

            </Form>

            <div className="flex">
                <Button onClick={e => { e.preventDefault(); updateCounter(fieldsCount + 1); }}>Add field</Button>
                <Button onClick={e => { e.preventDefault(); updateCounter(fieldsCount - 1); }}>Remove field</Button>
            </div>

        </React.Fragment>
    )
}

export default CreateTable;